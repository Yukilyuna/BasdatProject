<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private function getCart(): array
    {
        return session()->get('cart', []); // [medicine_id => ['id','name','price','qty','is_rx','slug']]
    }

    private function saveCart(array $cart): void
    {
        session(['cart' => $cart]);
    }

    public function index()
    {
        $cart = $this->getCart();
        $items = array_values($cart);
        $total = collect($items)->sum(fn($i) => $i['price'] * $i['qty']);
        $hasRx = collect($items)->contains(fn($i) => $i['is_rx'] === true);

        return view('shop.cart', compact('items', 'total', 'hasRx'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'slug' => ['required', 'string', 'exists:medicines,slug'],
            'qty'  => ['required', 'integer', 'min:1', 'max:999'],
        ]);

        $medicine = Medicine::where('slug', $request->slug)->firstOrFail();
        $cart = $this->getCart();

        if (!isset($cart[$medicine->id])) {
            $cart[$medicine->id] = [
                'id'    => $medicine->id,
                'slug'  => $medicine->slug,
                'name'  => $medicine->name,
                'price' => (float)$medicine->price,
                'qty'   => 0,
                'is_rx' => (bool)$medicine->is_prescription_only,
            ];
        }

        $cart[$medicine->id]['qty'] += (int)$request->qty;
        $this->saveCart($cart);

        return redirect()->route('shop.cart.index')->with('success', 'Item ditambahkan ke keranjang.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'id'  => ['required', 'integer', 'exists:medicines,id'],
            'qty' => ['required', 'integer', 'min:1', 'max:999'],
        ]);

        $cart = $this->getCart();
        if (!isset($cart[$request->id])) {
            return back()->with('error', 'Item tidak ada di keranjang.');
        }

        $cart[$request->id]['qty'] = (int)$request->qty;
        $this->saveCart($cart);

        return back()->with('success', 'Jumlah diperbarui.');
    }

    public function remove(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer', 'exists:medicines,id'],
        ]);

        $cart = $this->getCart();
        unset($cart[$request->id]);
        $this->saveCart($cart);

        return back()->with('success', 'Item dihapus.');
    }

    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Keranjang dikosongkan.');
    }
}

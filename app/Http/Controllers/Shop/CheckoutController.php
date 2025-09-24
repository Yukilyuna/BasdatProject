<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    private function getCart(): array
    {
        return session()->get('cart', []);
    }

    public function show()
    {
        $cart = $this->getCart();
        if (empty($cart)) {
            return redirect()->route('shop.cart.index')->with('error', 'Keranjang kosong.');
        }

        $items = array_values($cart);
        $total = collect($items)->sum(fn($i) => $i['price'] * $i['qty']);
        $hasRx = collect($items)->contains(fn($i) => $i['is_rx'] === true);

        return view('shop.checkout', compact('items', 'total', 'hasRx'));
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'recipient_name'   => ['required','string','min:3'],
            'recipient_phone'  => ['required','string','min:6'],
            'shipping_address' => ['required','string','min:8'],
        ]);

        $cart = $this->getCart();
        if (empty($cart)) {
            return redirect()->route('shop.cart.index')->with('error', 'Keranjang kosong.');
        }

        $items = array_values($cart);
        $hasRx = collect($items)->contains(fn($i) => $i['is_rx'] === true);
        $total = collect($items)->sum(fn($i) => $i['price'] * $i['qty']);

        $user = $request->user();

        $order = DB::transaction(function () use ($user, $items, $total, $hasRx, $request) {
            // Tentukan status awal
            $status = $hasRx ? 'awaiting_prescription_upload' : 'awaiting_payment';

            $order = Order::create([
                'user_id'          => $user->id,
                'status'           => $status,
                'total_amount'     => $total,
                'recipient_name'   => $request->recipient_name,
                'recipient_phone'  => $request->recipient_phone,
                'shipping_address' => $request->shipping_address,
            ]);

            foreach ($items as $i) {
                // Validasi medicine masih ada (untuk belajar stok tidak habis)
                $med = Medicine::findOrFail($i['id']);
                OrderItem::create([
                    'order_id'    => $order->id,
                    'medicine_id' => $med->id,
                    'qty'         => $i['qty'],
                    'unit_price'  => $i['price'],
                    'subtotal'    => $i['price'] * $i['qty'],
                ]);
            }

            return $order;
        });

        // Bersihkan keranjang
        session()->forget('cart');

        return redirect()->route('shop.orders.show', $order)->with('success',
            $hasRx
                ? 'Order dibuat. Silakan upload resep untuk melanjutkan.'
                : 'Order dibuat. Silakan lakukan pembayaran dalam 24 jam.'
        );
    }
}

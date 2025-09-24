<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PaymentProof;
use Illuminate\Http\Request;

class PaymentProofController extends Controller
{
    public function create(Order $order, Request $request)
    {
        if ($order->user_id !== $request->user()->id) abort(403);
        if (!in_array($order->status, ['awaiting_payment','payment_rejected'])) {
            return redirect()->route('shop.orders.show', $order)->with('error','Order ini tidak pada tahap pembayaran.');
        }
        return view('shop.payments.create', compact('order'));
    }

    public function store(Order $order, Request $request)
    {
        if ($order->user_id !== $request->user()->id) abort(403);
        if (!in_array($order->status, ['awaiting_payment','payment_rejected'])) {
            return redirect()->route('shop.orders.show', $order)->with('error','Status order tidak valid untuk upload bukti.');
        }

        $request->validate([
            'file' => ['required','file','mimes:jpg,jpeg,png,pdf','max:5120'],
        ]);

        $path = $request->file('file')->store('payments','public');

        PaymentProof::create([
            'order_id'     => $order->id,
            'user_id'      => $request->user()->id,
            'status'       => 'under_review',
            'file_path'    => $path,
            'reviewer_note'=> null,
        ]);

        $order->update(['status'=>'payment_under_review']);

        return redirect()->route('shop.orders.show',$order)->with('success','Bukti bayar terkirim. Menunggu review admin.');
    }
}

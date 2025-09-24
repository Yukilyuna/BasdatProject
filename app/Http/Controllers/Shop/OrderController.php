<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function show(Order $order, Request $request)
    {
        // Pastikan order milik user
        if ($order->user_id !== $request->user()->id) {
            abort(403);
        }
        $order->load(['items.medicine', 'prescription', 'paymentProofs', 'shipment']);
        return view('shop.order_show', compact('order'));
    }

    public function index(Request $request)
    {
        $status = $request->query('status'); // optional filter: open/closed/atau nama status spesifik

        $orders = \App\Models\Order::where('user_id', $request->user()->id)
            ->when($status, function ($q) use ($status) {
                if ($status === 'open') {
                    $q->whereNotIn('status', ['delivered','cancelled']);
                } elseif ($status === 'closed') {
                    $q->whereIn('status', ['delivered','cancelled']);
                } else {
                    // filter status spesifik (mis. awaiting_payment)
                    $q->where('status', $status);
                }
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('shop.orders.index', compact('orders','status'));
    }

}

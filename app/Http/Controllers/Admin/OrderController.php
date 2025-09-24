<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Shipment;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user','shipment')->latest()->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Order $order, Request $request)
    {
        $request->validate([
            'action'          => ['required','in:processing,ship,deliver,cancel'],
            'courier_name'    => ['nullable','string','max:100'],
            'tracking_number' => ['nullable','string','max:100'],
        ]);

        switch ($request->action) {
            case 'processing':
                if ($order->status === 'paid') $order->update(['status'=>'processing']);
                break;

            case 'ship':
                if (in_array($order->status, ['paid','processing'])) {
                    $order->update(['status'=>'shipped']);
                    $shipment = $order->shipment()->firstOrCreate([]);
                    $shipment->update([
                        'courier_name'    => $request->courier_name,
                        'tracking_number' => $request->tracking_number,
                        'shipped_at'      => now(),
                    ]);
                }
                break;

            case 'deliver':
                if ($order->status === 'shipped') {
                    $order->update(['status'=>'delivered']);
                    $order->shipment()->update(['delivered_at'=>now()]);
                }
                break;

            case 'cancel':
                if (!in_array($order->status, ['delivered','cancelled'])) {
                    $order->update(['status'=>'cancelled']);
                }
                break;
        }

        return back()->with('success','Status order diperbarui.');
    }
}

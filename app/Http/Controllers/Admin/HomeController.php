<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Prescription;
use App\Models\PaymentProof;

class HomeController extends Controller
{
    public function index()
    {
        $stats = [
            'rx_pending'      => Prescription::where('status','prescription_under_review')->count(),
            'pay_pending'     => PaymentProof::where('status','under_review')->count(),
            'orders_open'     => Order::whereNotIn('status',['delivered','cancelled'])->count(),
            'orders_today'    => Order::whereDate('created_at', now()->toDateString())->count(),
        ];

        $recentOrders = Order::with('user')->latest()->limit(8)->get();

        return view('admin.dashboard', compact('stats','recentOrders'));
    }
}

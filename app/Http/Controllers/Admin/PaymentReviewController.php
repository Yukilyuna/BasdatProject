<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PaymentProof;
use Illuminate\Http\Request;

class PaymentReviewController extends Controller
{
    public function index()
    {
        $pending = PaymentProof::with('order.user')
            ->where('status','under_review')
            ->latest()->paginate(20);

        return view('admin.payments.index', compact('pending'));
    }

    public function show(PaymentProof $payment)
    {
        $payment->load('order.items.medicine','user');
        return view('admin.payments.show', compact('payment'));
    }

    public function approve(PaymentProof $payment, Request $request)
    {
        $payment->update(['status'=>'approved','reviewer_note'=>$request->note]);

        $order = $payment->order;
        if ($order && in_array($order->status, ['payment_under_review','payment_rejected','awaiting_payment'])) {
            $order->update(['status'=>'paid']);
        }

        return redirect()->route('admin.payments.index')->with('success','Pembayaran disetujui.');
    }

    public function reject(PaymentProof $payment, Request $request)
    {
        $request->validate(['note'=>['required','string','min:5']]);
        $payment->update(['status'=>'rejected','reviewer_note'=>$request->note]);

        $order = $payment->order;
        if ($order) $order->update(['status'=>'payment_rejected']);

        return redirect()->route('admin.payments.index')->with('success','Pembayaran ditolak.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Prescription;
use Illuminate\Http\Request;

class PrescriptionReviewController extends Controller
{
    public function index()
    {
        $pending = Prescription::with('order.user')
            ->where('status','prescription_under_review')
            ->latest()->paginate(20);

        $rejected = Prescription::with('order.user')
            ->where('status','rejected')
            ->latest()->paginate(10);

        $approved = Prescription::with('order.user')
            ->where('status','approved')
            ->latest()->paginate(10);

        return view('admin.prescriptions.index', compact('pending','rejected','approved'));
    }

    public function show(Prescription $prescription)
    {
        $prescription->load('order.items.medicine','user');
        return view('admin.prescriptions.show', compact('prescription'));
    }

    public function approve(Prescription $prescription, Request $request)
    {
        $prescription->update([
            'status' => 'approved',
            'note'   => $request->note,
        ]);

        // order ke awaiting_payment
        $order = $prescription->order;
        if ($order && in_array($order->status, ['prescription_under_review','awaiting_prescription_upload','prescription_rejected'])) {
            $order->update(['status'=>'awaiting_payment']);
        }

        return redirect()->route('admin.prescriptions.index')->with('success','Resep disetujui.');
    }

    public function reject(Prescription $prescription, Request $request)
    {
        $request->validate(['note'=>['required','string','min:5']]);

        $prescription->update([
            'status' => 'rejected',
            'note'   => $request->note,
        ]);

        // order kembali ke awaiting_prescription_upload
        $order = $prescription->order;
        if ($order) {
            $order->update(['status'=>'awaiting_prescription_upload']);
        }

        return redirect()->route('admin.prescriptions.index')->with('success','Resep ditolak.');
    }
}

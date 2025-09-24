<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PrescriptionController extends Controller
{
    public function create(Order $order, Request $request)
    {
        // pastikan punya order & butuh resep
        if ($order->user_id !== $request->user()->id) abort(403);
        if (!in_array($order->status, ['awaiting_prescription_upload','prescription_rejected'])) {
            return redirect()->route('shop.orders.show', $order)->with('error','Order ini tidak membutuhkan upload resep.');
        }
        $prescription = $order->prescription;
        return view('shop.prescriptions.create', compact('order','prescription'));
    }

    public function store(Order $order, Request $request)
    {
        if ($order->user_id !== $request->user()->id) abort(403);
        if (!in_array($order->status, ['awaiting_prescription_upload','prescription_rejected'])) {
            return redirect()->route('shop.orders.show', $order)->with('error','Status order tidak valid untuk upload resep.');
        }

        $request->validate([
            'files.*' => ['required','file','mimes:jpg,jpeg,png,pdf','max:5120'], // 5MB
            'note'    => ['nullable','string','max:1000'],
        ]);

        $paths = [];
        foreach ($request->file('files', []) as $file) {
            $paths[] = $file->store('prescriptions','public');
        }

        $prescription = Prescription::updateOrCreate(
            ['order_id'=>$order->id],
            [
                'user_id'    => $request->user()->id,
                'status'     => 'prescription_under_review',
                'note'       => $request->note,
                'attachments'=> $paths,
            ]
        );

        $order->update(['status'=>'prescription_under_review']);

        return redirect()->route('shop.orders.show', $order)->with('success','Resep terkirim. Menunggu review admin.');
    }
}

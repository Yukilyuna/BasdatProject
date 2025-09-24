<x-app-layout>
  <x-slot name="header"><h2 class="font-display text-2xl text-brand-800">Bukti Pembayaran — Order #{{ $payment->order_id }}</h2></x-slot>

  <div class="admin-grid section">
    @include('admin.partials.sidebar')

    <div class="section">
      <div class="grid lg:grid-cols-2 gap-6">
        <div class="card pad">
          <div class="font-semibold mb-3">Informasi</div>
          <div class="text-sm space-y-2">
            <div>Customer: <b>{{ $payment->user->name }}</b> <span class="text-gray-500">({{ $payment->user->email }})</span></div>
            <div>Status Bukti: <x-status-badge :status="$payment->status" /></div>
            <div>Status Order: <x-status-badge :status="$payment->order->status" /></div>
            @if($payment->reviewer_note)
              <div class="p-3 bg-gray-50 rounded-xl">Catatan: {{ $payment->reviewer_note }}</div>
            @endif
          </div>
        </div>

        <div class="card pad">
          <div class="font-semibold mb-3">Lampiran</div>
          <a class="btn btn-primary" href="{{ asset('storage/'.$payment->file_path) }}" target="_blank">Buka Bukti Pembayaran</a>
        </div>
      </div>

      <div class="card pad">
        <div class="font-semibold mb-3">Aksi</div>
        <div class="flex flex-wrap gap-3">
          <form method="POST" action="{{ route('admin.payments.approve',$payment) }}">
            @csrf
            <input type="text" name="note" placeholder="Catatan (opsional)" class="border rounded-xl px-3 py-2">
            <button class="btn btn-primary px-5">Approve</button>
          </form>

          <form method="POST" action="{{ route('admin.payments.reject',$payment) }}">
            @csrf
            <input type="text" name="note" placeholder="Alasan tolak (wajib)" class="border rounded-xl px-3 py-2" required>
            <button class="btn px-5 bg-red-600 text-white hover:bg-red-700">Reject</button>
          </form>
        </div>
      </div>

      <a class="text-brand-700 underline" href="{{ route('admin.payments.index') }}">← Kembali</a>
    </div>
  </div>
</x-app-layout>

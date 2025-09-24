<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="text-2xl font-semibold">Order #{{ $order->id }}</h2>

      <div class="flex items-center gap-2">
        <a href="{{ route('shop.index') }}" class="btn btn-white px-3 py-1">← Katalog</a>
        <a href="{{ route('shop.orders.index') }}" class="btn btn-white px-3 py-1">Pesanan Saya</a>
      </div>
    </div>
  </x-slot>

  <div class="p-6 space-y-6">
    @if (session('success')) <div class="text-green-700">{{ session('success') }}</div> @endif
    @if (session('error'))   <div class="text-red-700">{{ session('error') }}</div> @endif

    <div class="space-y-1">
      <div>Status: <b>{{ $order->status }}</b></div>
      <div>Total: <b>Rp {{ number_format($order->total_amount,0,',','.') }}</b></div>
      <div>Penerima: {{ $order->recipient_name }} ({{ $order->recipient_phone }})</div>
      <div>Alamat: {{ $order->shipping_address }}</div>
    </div>

    <div>
      <h3 class="font-semibold mb-2">Item</h3>
      <table class="min-w-full border">
        <thead><tr class="bg-gray-50">
          <th class="p-2 text-left">Obat</th><th class="p-2">Qty</th><th class="p-2">Harga</th><th class="p-2">Subtotal</th>
        </tr></thead>
        <tbody>
          @foreach($order->items as $it)
            <tr class="border-t">
              <td class="p-2">{{ $it->medicine->name ?? 'Unknown' }}</td>
              <td class="p-2 text-center">{{ $it->qty }}</td>
              <td class="p-2">Rp {{ number_format($it->unit_price,0,',','.') }}</td>
              <td class="p-2">Rp {{ number_format($it->subtotal,0,',','.') }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    {{-- ACTION PANEL --}}
    <div class="p-3 bg-gray-50 rounded space-y-2">
      @switch($order->status)
        @case('awaiting_prescription_upload')
          <div>Order ini <b>membutuhkan resep</b>. Silakan upload resep untuk melanjutkan.</div>
          <a href="{{ route('shop.prescriptions.create',$order) }}" class="inline-block mt-1 px-3 py-2 bg-black text-white rounded">Upload Resep</a>
          @break

        @case('prescription_rejected')
          <div>Resep <b>ditolak</b>. Silakan upload ulang resep.</div>
          <a href="{{ route('shop.prescriptions.create',$order) }}" class="inline-block mt-1 px-3 py-2 bg-black text-white rounded">Upload Ulang Resep</a>
          @break

        @case('prescription_under_review')
          <div>Resep sedang ditinjau admin.</div>
          @break

        @case('awaiting_payment')
          <div>Silakan lakukan pembayaran ke rekening BCA 0991101470 (an. Shidqy Baihaqy) dalam 24 jam, lalu upload bukti.</div>
          <a href="{{ route('shop.payments.create',$order) }}" class="inline-block mt-1 px-3 py-2 bg-black text-white rounded">Upload Bukti Pembayaran</a>
          @break

        @case('payment_rejected')
          <div>Bukti pembayaran <b>ditolak</b>. Silakan upload ulang bukti pembayaran.</div>
          <a href="{{ route('shop.payments.create',$order) }}" class="inline-block mt-1 px-3 py-2 bg-black text-white rounded">Upload Ulang Bukti</a>
          @break

        @case('payment_under_review')
          <div>Bukti pembayaran sedang ditinjau admin.</div>
          @break

        @case('paid')
          <div>Pembayaran diterima. Order diproses.</div>
          @break

        @case('processing')
          <div>Order sedang diproses.</div>
          @break

        @case('shipped')
          <div>Order sudah dikirim. Menunggu <b>delivered</b>.</div>
          @break

        @case('delivered')
          <div>Order selesai. Terima kasih!</div>
          @break

        @case('cancelled')
          <div>Order dibatalkan.</div>
          @break

        @default
          <div>Status: {{ $order->status }}</div>
      @endswitch
    </div>
  </div>
</x-app-layout>

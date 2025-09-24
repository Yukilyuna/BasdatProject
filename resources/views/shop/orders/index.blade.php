{{-- resources/views/shop/orders/index.blade.php --}}
<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="text-2xl font-semibold">Pesanan Saya</h2>
      <a href="{{ route('shop.index') }}" class="btn btn-white px-3 py-1">← Katalog</a>
    </div>
  </x-slot>

  <div class="section">
    {{-- Filter --}}
    <div class="card pad">
      <form method="GET" class="flex flex-wrap items-center gap-2">
        @php($status = request('status'))
        <label class="text-sm text-gray-600">Filter:</label>

        <select name="status" class="rounded-lg border-gray-300 focus:border-brand-400 focus:ring-brand-300">
          <option value="" {{ $status==='' || $status===null ? 'selected' : '' }}>Semua</option>
          <option value="open"    {{ $status==='open'    ? 'selected' : '' }}>Masih Berjalan</option>
          <option value="closed"  {{ $status==='closed'  ? 'selected' : '' }}>Selesai/Dibatalkan</option>

          @foreach([
            'awaiting_prescription_upload',
            'prescription_under_review',
            'prescription_rejected',
            'awaiting_payment',
            'payment_under_review',
            'payment_rejected',
            'paid',
            'processing',
            'shipped',
            'delivered',
            'cancelled'
          ] as $s)
            <option value="{{ $s }}" {{ $status===$s ? 'selected' : '' }}>{{ $s }}</option>
          @endforeach
        </select>

        <button class="btn btn-primary">Terapkan</button>

        @if ($status)
          <a href="{{ route('shop.orders.index') }}" class="text-sm text-brand-700 underline">Reset</a>
        @endif
      </form>
    </div>

    {{-- Tabel pesanan --}}
    <div class="table-wrap">
      <table class="min-w-full text-sm table-ui">
        <thead>
          <tr>
            <th>Order</th>
            <th>Tanggal</th>
            <th>Status</th>
            <th class="text-right">Total</th>
            <th>Aksi</th>
          </tr>
        </thead>

        <tbody class="divide-y">
          @forelse($orders as $o)
            <tr class="hover:bg-brand-50/30">
              <td>#{{ $o->id }}</td>
              <td>{{ $o->created_at->format('d M Y H:i') }}</td>
              <td>{{ $o->status }}</td>
              <td class="text-right">Rp {{ number_format($o->total_amount,0,',','.') }}</td>
              <td>
                <a class="btn btn-white px-3 py-1" href="{{ route('shop.orders.show', $o) }}">Detail</a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="py-6 text-center text-gray-500">Tidak ada pesanan.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div>{{ $orders->links() }}</div>
  </div>
</x-app-layout>

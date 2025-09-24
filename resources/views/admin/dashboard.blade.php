<x-app-layout>
  <x-slot name="header"><h2 class="font-display text-2xl text-brand-800">Admin Dashboard</h2></x-slot>

  <div class="admin-grid section">
    @include('admin.partials.sidebar')

    <div class="section">
      <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="card pad">
          <div class="text-sm text-gray-500">Resep Menunggu</div>
          <div class="text-3xl font-bold">{{ $stats['rx_pending'] }}</div>
        </div>
        <div class="card pad">
          <div class="text-sm text-gray-500">Pembayaran Menunggu</div>
          <div class="text-3xl font-bold">{{ $stats['pay_pending'] }}</div>
        </div>
        <div class="card pad">
          <div class="text-sm text-gray-500">Order Berjalan</div>
          <div class="text-3xl font-bold">{{ $stats['orders_open'] }}</div>
        </div>
        <div class="card pad">
          <div class="text-sm text-gray-500">Order Hari Ini</div>
          <div class="text-3xl font-bold">{{ $stats['orders_today'] }}</div>
        </div>
      </div>

      <div class="card pad">
        <div class="flex items-center justify-between mb-4">
          <div class="font-semibold text-lg">Order Terbaru</div>
          <a href="{{ route('admin.orders.index') }}" class="text-brand-700 underline">Lihat Semua</a>
        </div>
        <div class="table-wrap">
          <table class="min-w-full text-sm table-ui">
            <thead>
              <tr>
                <th>Order</th><th>Customer</th><th>Tanggal</th><th>Status</th><th class="text-right">Total</th>
              </tr>
            </thead>
            <tbody class="divide-y">
              @forelse($recentOrders as $o)
                <tr class="hover:bg-brand-50/30">
                  <td>#{{ $o->id }}</td>
                  <td>{{ $o->user->name }}</td>
                  <td>{{ $o->created_at->format('d M Y H:i') }}</td>
                  <td><x-status-badge :status="$o->status"/></td>
                  <td class="text-right">Rp {{ number_format($o->total_amount,0,',','.') }}</td>
                </tr>
              @empty
                <tr><td colspan="5" class="py-6 text-center text-gray-500">Belum ada order.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>

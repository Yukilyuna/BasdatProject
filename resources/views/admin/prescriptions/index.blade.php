<x-app-layout>
  <x-slot name="header"><h2 class="font-display text-2xl text-brand-800">Review Resep</h2></x-slot>

  <div class="admin-grid section">
    @include('admin.partials.sidebar')

    <div class="section">
      @if(session('success'))
        <div class="card pad text-emerald-700">{{ session('success') }}</div>
      @endif

      {{-- ringkasan --}}
      <div class="grid sm:grid-cols-3 gap-4">
        <div class="card pad">
          <div class="text-sm text-gray-500">Menunggu Review</div>
          <div class="text-3xl font-bold">{{ method_exists($pending,'total') ? $pending->total() : $pending->count() }}</div>
        </div>
        <div class="card pad">
          <div class="text-sm text-gray-500">Disetujui</div>
          <div class="text-3xl font-bold">{{ isset($approved) && method_exists($approved,'total') ? $approved->total() : ($approved->count() ?? 0) }}</div>
        </div>
        <div class="card pad">
          <div class="text-sm text-gray-500">Ditolak</div>
          <div class="text-3xl font-bold">{{ isset($rejected) && method_exists($rejected,'total') ? $rejected->total() : ($rejected->count() ?? 0) }}</div>
        </div>
      </div>

      {{-- tabel pending --}}
      <div class="card pad">
        <div class="font-semibold text-lg mb-4">Daftar Resep Menunggu</div>

        <div class="table-wrap">
          <table class="min-w-full text-sm table-ui">
            <thead>
              <tr>
                <th>Order</th>
                <th>Customer</th>
                <th>Diunggah</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y">
              @forelse($pending as $p)
                <tr class="hover:bg-brand-50/30">
                  <td>#{{ $p->order_id }}</td>
                  <td>{{ $p->order->user->name }} <span class="text-xs text-gray-500">({{ $p->order->user->email }})</span></td>
                  <td>{{ $p->created_at?->format('d M Y H:i') }}</td>
                  <td><x-status-badge :status="$p->status" /></td>
                  <td>
                    <a class="btn btn-primary px-3 py-1" href="{{ route('admin.prescriptions.show',$p) }}">Lihat</a>
                  </td>
                </tr>
              @empty
                <tr><td colspan="5" class="py-6 text-center text-gray-500">Tidak ada resep menunggu.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div class="mt-4">
          {{ method_exists($pending,'links') ? $pending->links() : '' }}
        </div>
      </div>
    </div>
  </div>
</x-app-layout>

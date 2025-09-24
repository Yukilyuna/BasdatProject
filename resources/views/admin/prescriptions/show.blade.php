<x-app-layout>
  <x-slot name="header"><h2 class="font-display text-2xl text-brand-800">Resep — Order #{{ $prescription->order_id }}</h2></x-slot>

  <div class="admin-grid section">
    @include('admin.partials.sidebar')

    <div class="section">
      {{-- info + lampiran --}}
      <div class="grid lg:grid-cols-2 gap-6">
        <div class="card pad">
          <div class="font-semibold mb-3">Informasi</div>
          <div class="text-sm space-y-2">
            <div>Pemilik: <b>{{ $prescription->user->name }}</b> <span class="text-gray-500">({{ $prescription->user->email }})</span></div>
            <div>Status Resep: <x-status-badge :status="$prescription->status" /></div>
            <div>Status Order: <x-status-badge :status="$prescription->order->status" /></div>
            @if($prescription->note)
              <div class="p-3 bg-gray-50 rounded-xl">Catatan: {{ $prescription->note }}</div>
            @endif
          </div>
        </div>

        <div class="card pad">
          <div class="font-semibold mb-3">Lampiran</div>
          <ul class="list-disc ml-6 text-sm space-y-1">
            @forelse(($prescription->attachments ?? []) as $path)
              <li>
                <a class="text-brand-700 underline" target="_blank" href="{{ asset('storage/'.$path) }}">
                  {{ basename($path) }}
                </a>
              </li>
            @empty
              <li class="text-gray-500">Tidak ada lampiran.</li>
            @endforelse
          </ul>
        </div>
      </div>

      {{-- items --}}
      <div class="card pad">
        <div class="font-semibold mb-3">Item pada Order</div>
        <div class="table-wrap">
          <table class="min-w-full text-sm table-ui">
            <thead>
              <tr>
                <th>Obat</th><th class="text-center">Qty</th>
              </tr>
            </thead>
            <tbody class="divide-y">
              @foreach($prescription->order->items as $it)
                <tr>
                  <td>{{ $it->medicine->name ?? 'Unknown' }}</td>
                  <td class="text-center">{{ $it->qty }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

      {{-- aksi --}}
      <div class="card pad">
        <div class="font-semibold mb-3">Aksi</div>
        <div class="flex flex-wrap gap-3">
          <form method="POST" action="{{ route('admin.prescriptions.approve',$prescription) }}">
            @csrf
            <input type="text" name="note" placeholder="Catatan (opsional)" class="border rounded-xl px-3 py-2">
            <button class="btn btn-primary px-5">Approve</button>
          </form>

          <form method="POST" action="{{ route('admin.prescriptions.reject',$prescription) }}">
            @csrf
            <input type="text" name="note" placeholder="Alasan tolak (wajib)" class="border rounded-xl px-3 py-2" required>
            <button class="btn px-5 bg-red-600 text-white hover:bg-red-700">Reject</button>
          </form>
        </div>
      </div>

      <a class="text-brand-700 underline" href="{{ route('admin.prescriptions.index') }}">← Kembali</a>
    </div>
  </div>
</x-app-layout>

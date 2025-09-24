<x-app-layout>
  <x-slot name="header"><h2 class="text-2xl font-semibold">Stok Obat</h2></x-slot>

  <div class="admin-grid section">
    @include('admin.partials.sidebar')

    <div class="section">
      @if(session('success')) <div class="card pad text-emerald-700">{{ session('success') }}</div> @endif
      @if(session('error'))   <div class="card pad text-red-700">{{ session('error') }}</div> @endif

      <div class="flex items-center justify-end">
        <a href="{{ route('admin.medicines.create') }}" class="btn btn-primary">+ Tambah Obat</a>
      </div>

      <div class="table-wrap">
        <table class="min-w-full text-sm table-ui">
          <thead>
            <tr>
              <th>Obat</th>
              <th>Kategori</th>
              <th class="text-right">Harga</th>
              <th class="text-center">Resep</th>
              <th class="text-center">Stok</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y">
            @foreach($medicines as $m)
              <tr class="hover:bg-brand-50/30">
                <td class="font-medium">{{ $m->name }}</td>
                <td>{{ $m->category->name ?? '-' }}</td>
                <td class="text-right">Rp {{ number_format($m->price,0,',','.') }}</td>
                <td class="text-center">
                  @if($m->is_prescription_only)
                    <span class="badge-rx">Perlu Resep</span>
                  @else
                    <span class="badge-ok">Bebas</span>
                  @endif
                </td>
                <td class="text-center font-semibold">{{ $m->stock }}</td>
                <td>
                  <form method="POST" action="{{ route('admin.medicines.addStock', $m) }}" class="flex items-center gap-2">
                    @csrf
                    <input type="number" name="qty" min="1" value="1" class="w-24 border rounded-xl px-3 py-2">
                    <button class="btn btn-primary px-3 py-2">Tambah Stok</button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <div>{{ $medicines->links() }}</div>
    </div>
  </div>
</x-app-layout>

<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="font-display text-3xl text-brand-800">Kategori Obat</h2>
      <form method="GET" class="flex gap-2">
        <input type="hidden" name="category" value="{{ request('category') }}">
        <input name="q" value="{{ request('q') }}" placeholder="Cari obat..."
               class="rounded-full border-gray-200 bg-white/70 px-4 py-2 focus:ring-brand-300 focus:border-brand-400">
        <button class="btn btn-primary">Cari</button>
      </form>
    </div>
  </x-slot>

  <div class="grid md:grid-cols-[18rem_1fr] gap-6">
    @include('shop.partials.category-sidebar')

    <div class="section">
      @if($activeCategory)
        <div class="card pad">
          <div class="text-sm text-gray-600">{{ $activeCategory->parent?->name ?? 'Kategori' }}</div>
          <div class="text-2xl font-display">{{ $activeCategory->name }}</div>
        </div>
      @endif

      @if (session('success')) <div class="card pad text-emerald-700">{{ session('success') }}</div> @endif
      @if (session('error'))   <div class="card pad text-red-700">{{ session('error') }}</div> @endif

      <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($medicines as $m)
          <div class="card pad">
            <div class="text-lg font-semibold">{{ $m->name }}</div>
            <div class="text-sm text-gray-600 mb-2">{{ $m->category->name ?? '-' }}</div>
            <div class="mb-2">Rp {{ number_format($m->price,0,',','.') }}</div>
            @if($m->is_prescription_only)
              <span class="badge-rx">Perlu Resep</span>
            @else
              <span class="badge-ok">Tanpa Resep</span>
            @endif

            <div class="mt-3 flex gap-2">
              <a class="text-brand-700 underline" href="{{ route('shop.product.show', $m->slug) }}">Detail</a>
              <form method="POST" action="{{ route('shop.cart.add') }}" class="ml-auto flex gap-2">
                @csrf
                <input type="hidden" name="slug" value="{{ $m->slug }}">
                <input type="number" name="qty" value="1" min="1" class="w-16 border rounded-full px-3 py-1">
                <button class="btn btn-primary">Tambah</button>
              </form>
            </div>
          </div>
        @empty
          <div class="col-span-full card pad">Tidak ada obat.</div>
        @endforelse
      </div>

      <div>{{ $medicines->links() }}</div>
    </div>
  </div>
</x-app-layout>

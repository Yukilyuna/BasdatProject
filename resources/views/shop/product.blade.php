<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $medicine->name }}</h2>
  </x-slot>

  <div class="p-6 space-y-4">
    <div>Kategori: {{ $medicine->category->name ?? '-' }}</div>
    <div>Harga: Rp {{ number_format($medicine->price,0,',','.') }}</div>
    <div>{!! nl2br(e($medicine->description)) !!}</div>
    <div>
      @if($medicine->is_prescription_only)
        <span class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded">Perlu Resep</span>
      @else
        <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded">Tanpa Resep</span>
      @endif
    </div>

    <form method="POST" action="{{ route('shop.cart.add') }}" class="flex gap-2">
      @csrf
      <input type="hidden" name="slug" value="{{ $medicine->slug }}">
      <input type="number" name="qty" value="1" min="1" class="w-20 border rounded px-2 py-1">
      <button class="bg-black text-white px-4 py-2 rounded">Tambah ke Keranjang</button>
    </form>
  </div>
</x-app-layout>

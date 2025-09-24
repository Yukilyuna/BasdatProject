<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h1 class="text-2xl font-semibold">{{ $medicine->name }}</h1>
      <div class="flex gap-2">
        @if($medicine->category)
          <a href="{{ route('shop.index', ['category' => $medicine->category->slug]) }}"
             class="btn btn-white px-3 py-1">← {{ $medicine->category->name }}</a>
        @endif
        <a href="{{ route('shop.index') }}" class="btn btn-white px-3 py-1">Katalog</a>
      </div>
    </div>
  </x-slot>

  {{-- ...konten produk --}}
</x-app-layout>

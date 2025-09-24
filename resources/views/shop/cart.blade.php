<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="text-2xl font-semibold">Keranjang</h2>
      <a href="{{ route('shop.index') }}" class="btn btn-white px-3 py-1">← Katalog</a>
    </div>
  </x-slot>

  <div class="p-6 space-y-4">
    @if (session('success')) <div class="text-green-700">{{ session('success') }}</div> @endif
    @if (session('error'))   <div class="text-red-700">{{ session('error') }}</div> @endif

    @if (count($items) === 0)
      <div>Keranjang kosong.</div>
    @else
      @if ($hasRx)
        <div class="p-3 bg-yellow-50 border border-yellow-200 rounded">
          Order ini mengandung item <b>perlu resep</b>. Seluruh order akan tertahan hingga resep disetujui admin.
        </div>
      @endif

      <table class="min-w-full border">
        <thead>
          <tr class="bg-gray-50">
            <th class="p-2 text-left">Obat</th>
            <th class="p-2">Qty</th>
            <th class="p-2">Harga</th>
            <th class="p-2">Subtotal</th>
            <th class="p-2"></th>
          </tr>
        </thead>
        <tbody>
          @foreach($items as $it)
            <tr class="border-t">
              <td class="p-2">
                <a class="underline" href="{{ route('shop.product.show',$it['slug']) }}">{{ $it['name'] }}</a>
                @if($it['is_rx'])
                  <span class="ml-2 text-xs bg-red-100 text-red-700 px-2 py-0.5 rounded">Perlu Resep</span>
                @endif
              </td>
              <td class="p-2">
                <form method="POST" action="{{ route('shop.cart.update') }}" class="flex gap-2">
                  @csrf
                  <input type="hidden" name="id" value="{{ $it['id'] }}">
                  <input type="number" name="qty" value="{{ $it['qty'] }}" min="1" class="w-20 border rounded px-2 py-1">
                  <button class="px-2 py-1 bg-blue-600 text-white rounded">Update</button>
                </form>
              </td>
              <td class="p-2">Rp {{ number_format($it['price'],0,',','.') }}</td>
              <td class="p-2">Rp {{ number_format($it['price']*$it['qty'],0,',','.') }}</td>
              <td class="p-2">
                <form method="POST" action="{{ route('shop.cart.remove') }}">
                  @csrf
                  <input type="hidden" name="id" value="{{ $it['id'] }}">
                  <button class="px-2 py-1 bg-red-600 text-white rounded">Hapus</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>

      <div class="flex items-center justify-between mt-4">
        <form method="POST" action="{{ route('shop.cart.clear') }}">
          @csrf
          <button class="px-3 py-2 bg-gray-200 rounded">Kosongkan</button>
        </form>

        <div class="text-right">
          <div class="text-lg mb-2">Total: <b>Rp {{ number_format($total,0,',','.') }}</b></div>
          <a href="{{ route('shop.checkout.show') }}" class="px-4 py-2 bg-black text-white rounded">Checkout</a>
        </div>
      </div>
    @endif
  </div>
</x-app-layout>

<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="text-2xl font-semibold">Checkout</h2>
      <div class="flex gap-2">
        <a href="{{ route('shop.cart.index') }}" class="btn btn-white px-3 py-1">← Keranjang</a>
        <a href="{{ route('shop.index') }}" class="btn btn-white px-3 py-1">Katalog</a>
      </div>
    </div>
  </x-slot>

  <div class="p-6 space-y-6">
    @if ($hasRx)
      <div class="p-3 bg-yellow-50 border border-yellow-200 rounded">
        Order ini mengandung item <b>perlu resep</b>. Setelah order dibuat:
        <ul class="list-disc ml-5">
          <li>Status awal: <code>awaiting_prescription_upload</code></li>
          <li>Kamu harus upload resep & menunggu persetujuan admin sebelum bisa bayar.</li>
        </ul>
      </div>
    @endif

    <div>
      <h3 class="font-semibold mb-2">Ringkasan</h3>
      <table class="min-w-full border">
        <thead><tr class="bg-gray-50">
          <th class="p-2 text-left">Obat</th><th class="p-2">Qty</th><th class="p-2">Harga</th><th class="p-2">Subtotal</th>
        </tr></thead>
        <tbody>
        @foreach($items as $it)
          <tr class="border-t">
            <td class="p-2">{{ $it['name'] }} @if($it['is_rx']) <span class="ml-2 text-xs bg-red-100 text-red-700 px-2 py-0.5 rounded">Rx</span> @endif</td>
            <td class="p-2 text-center">{{ $it['qty'] }}</td>
            <td class="p-2">Rp {{ number_format($it['price'],0,',','.') }}</td>
            <td class="p-2">Rp {{ number_format($it['price']*$it['qty'],0,',','.') }}</td>
          </tr>
        @endforeach
        </tbody>
      </table>
      <div class="text-right mt-2 text-lg">Total: <b>Rp {{ number_format($total,0,',','.') }}</b></div>
    </div>

    <form method="POST" action="{{ route('shop.checkout.place') }}" class="space-y-3">
      @csrf
      <div>
        <label class="block text-sm mb-1">Nama Penerima</label>
        <input name="recipient_name" class="w-full border rounded px-3 py-2" required value="{{ old('recipient_name') }}">
        @error('recipient_name')<div class="text-red-700 text-sm">{{ $message }}</div>@enderror
      </div>
      <div>
        <label class="block text-sm mb-1">No. HP Penerima</label>
        <input name="recipient_phone" class="w-full border rounded px-3 py-2" required value="{{ old('recipient_phone') }}">
        @error('recipient_phone')<div class="text-red-700 text-sm">{{ $message }}</div>@enderror
      </div>
      <div>
        <label class="block text-sm mb-1">Alamat Pengiriman</label>
        <textarea name="shipping_address" class="w-full border rounded px-3 py-2" rows="3" required>{{ old('shipping_address') }}</textarea>
        @error('shipping_address')<div class="text-red-700 text-sm">{{ $message }}</div>@enderror
      </div>

      <button class="px-4 py-2 bg-black text-white rounded">Buat Order</button>
    </form>
  </div>
</x-app-layout>

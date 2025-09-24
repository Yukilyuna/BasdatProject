<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl">Upload Bukti Pembayaran — Order #{{ $order->id }}</h2>
  </x-slot>

  <div class="p-6 space-y-4">
    <div class="p-3 bg-blue-50 border border-blue-200 rounded">
      Transfer sesuai nominal total. Unggah 1 file (jpg/png/pdf). Setelah dikirim, status jadi <b>payment_under_review</b>.
    </div>

    <form method="POST" action="{{ route('shop.payments.store',$order) }}" enctype="multipart/form-data" class="space-y-3">
      @csrf
      <input type="file" name="file" class="border rounded px-3 py-2 w-full" required>
      @error('file')<div class="text-red-700 text-sm">{{ $message }}</div>@enderror
      <button class="px-4 py-2 bg-black text-white rounded">Kirim Bukti</button>
      <a class="underline ml-2" href="{{ route('shop.orders.show',$order) }}">Kembali</a>
    </form>
  </div>
</x-app-layout>

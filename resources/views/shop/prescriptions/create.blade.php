<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl">Upload Resep — Order #{{ $order->id }}</h2>
  </x-slot>

  <div class="p-6 space-y-4">
    <div class="p-3 bg-yellow-50 border border-yellow-200 rounded">
      Unggah 1–3 file (jpg/png/pdf). Setelah terkirim, status menjadi <b>prescription_under_review</b>.
    </div>

    <form method="POST" action="{{ route('shop.prescriptions.store',$order) }}" enctype="multipart/form-data" class="space-y-3">
      @csrf
      <input type="file" name="files[]" multiple class="border rounded px-3 py-2 w-full" required>
      @error('files.*')<div class="text-red-700 text-sm">{{ $message }}</div>@enderror

      <textarea name="note" rows="3" class="border rounded px-3 py-2 w-full" placeholder="Catatan (opsional)">{{ old('note',$prescription->note ?? '') }}</textarea>
      @error('note')<div class="text-red-700 text-sm">{{ $message }}</div>@enderror

      <button class="px-4 py-2 bg-black text-white rounded">Kirim Resep</button>
      <a class="underline ml-2" href="{{ route('shop.orders.show',$order) }}">Kembali</a>
    </form>

    @if($prescription && $prescription->attachments)
      <div class="mt-6">
        <h3 class="font-semibold mb-2">Lampiran Terkini</h3>
        <ul class="list-disc ml-6">
          @foreach($prescription->attachments as $p)
            <li><a class="text-blue-700 underline" href="{{ asset('storage/'.$p) }}" target="_blank">{{ basename($p) }}</a></li>
          @endforeach
        </ul>
      </div>
    @endif
  </div>
</x-app-layout>

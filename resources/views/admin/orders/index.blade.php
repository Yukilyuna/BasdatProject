<x-app-layout>
  <x-slot name="header"><h2 class="font-display text-2xl text-brand-800">Manajemen Order</h2></x-slot>

  <div class="admin-grid section">
    @include('admin.partials.sidebar')

    <div class="section">
      @if(session('success'))<div class="card pad text-emerald-700">{{ session('success') }}</div>@endif

      <div class="table-wrap">
        <table class="min-w-full text-sm table-ui">
          <thead>
            <tr>
              <th>Order</th><th>Customer</th><th>Status</th>
              <th class="text-right">Total</th><th>Pengiriman</th><th>Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y">
            @foreach($orders as $o)
              <tr class="hover:bg-brand-50/30">
                <td>#{{ $o->id }}</td>
                <td>{{ $o->user->name }}</td>
                <td><x-status-badge :status="$o->status"/></td>
                <td class="text-right">Rp {{ number_format($o->total_amount,0,',','.') }}</td>
                <td>
                  @if($o->shipment)
                    <div class="text-xs">{{ $o->shipment->courier_name }} / {{ $o->shipment->tracking_number }}</div>
                  @else
                    <span class="text-xs text-gray-500">-</span>
                  @endif
                </td>
                <td>
                  <form method="POST" action="{{ route('admin.orders.updateStatus',$o) }}" class="flex flex-wrap gap-2 items-center">
                    @csrf
                    <select name="action" class="border rounded-xl px-2 py-2">
                      <option value="processing">Processing</option>
                      <option value="ship">Shipped</option>
                      <option value="deliver">Delivered</option>
                      <option value="cancel">Cancel</option>
                    </select>
                    <input name="courier_name" placeholder="Kurir" class="border rounded-xl px-3 py-2" value="{{ $o->shipment->courier_name ?? '' }}">
                    <input name="tracking_number" placeholder="No. Resi" class="border rounded-xl px-3 py-2" value="{{ $o->shipment->tracking_number ?? '' }}">
                    <button class="btn btn-primary px-4 py-2">Apply</button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <div>{{ $orders->links() }}</div>
    </div>
  </div>
</x-app-layout>

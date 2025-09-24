<aside class="card pad w-full md:w-[280px] h-fit sticky top-28">
  <div class="font-semibold text-lg mb-3">Admin Panel</div>
  <nav class="flex flex-col gap-1">
    <a href="{{ route('admin.dashboard') }}"
       class="px-4 py-2 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-brand-50 text-brand-700' : 'hover:bg-brand-50' }}">Dashboard</a>
    <a href="{{ route('admin.prescriptions.index') }}"
       class="px-4 py-2 rounded-xl {{ request()->routeIs('admin.prescriptions.*') ? 'bg-brand-50 text-brand-700' : 'hover:bg-brand-50' }}">Review Resep</a>
    <a href="{{ route('admin.payments.index') }}"
       class="px-4 py-2 rounded-xl {{ request()->routeIs('admin.payments.*') ? 'bg-brand-50 text-brand-700' : 'hover:bg-brand-50' }}">Review Pembayaran</a>
    <a href="{{ route('admin.orders.index') }}"
       class="px-4 py-2 rounded-xl {{ request()->routeIs('admin.orders.*') ? 'bg-brand-50 text-brand-700' : 'hover:bg-brand-50' }}">Manajemen Order</a>
    <a href="{{ route('admin.medicines.index') }}"
        class="px-4 py-2 rounded-xl {{ request()->routeIs('admin.medicines.*') ? 'bg-brand-50 text-brand-700' : 'hover:bg-brand-50' }}">
        Stok Obat
    </a>
</aside>

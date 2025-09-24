{{-- resources/views/layouts/navigation.blade.php --}}
<nav x-data="{ open: false }" class="relative z-50 bg-white/80 backdrop-blur border-b">
    <div class="mx-auto max-w-7xl px-4">
        <div class="flex h-16 items-center gap-3">
            {{-- Hamburger (mobile) --}}
            <button @click="open = !open"
                class="md:hidden inline-flex items-center justify-center p-2 rounded hover:bg-brand-50"
                aria-label="Toggle menu">
                <svg class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"/>
                    <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center">
            <x-brand />
            </a>

            {{-- Search (desktop) --}}
            @auth
            <form action="{{ route('shop.index') }}" class="hidden md:flex flex-1 max-w-xl ml-4">
                <div class="relative w-full">
                    <input type="text" name="q" value="{{ request('q') }}"
                        placeholder="Cari obat..."
                        class="w-full rounded-full border-gray-200 bg-white/70 pl-10 pr-4 py-2
                               focus:ring-brand-300 focus:border-brand-400">
                    <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="m21 21-4.35-4.35M10 18a8 8 0 1 1 0-16 8 8 0 0 1 0 16z"/>
                    </svg>
                </div>
                <button class="btn btn-primary ml-2">Cari</button>
            </form>
            @endauth

            {{-- Right side --}}
            <div class="ml-auto flex items-center gap-3">
                @auth
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-white">Admin</a>
                    @else
                        <a href="{{ route('shop.cart.index') }}" class="btn btn-white">Cart</a>
                        <a href="{{ route('shop.orders.index') }}" class="btn btn-white">Pesanan</a>
                    @endif

                    {{-- Tombol logout langsung (POST) --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-white">Log Out</button>
                    </form>

                    {{-- Dropdown akun (opsional) --}}
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="hidden md:inline-flex items-center rounded-full bg-white px-3 py-2 border hover:bg-brand-50">
                                <div>{{ Auth::user()->name ?? 'Account' }}</div>
                                <div class="ms-1">
                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">Profile</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    Log Out
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                @endauth
            </div>
        </div>

        {{-- Mobile panel --}}
        <div x-show="open" x-cloak class="md:hidden pb-3">
            @auth
                <div class="pt-2 flex flex-col gap-2">
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-white w-full text-left">Admin</a>
                    @else
                        <a href="{{ route('shop.index') }}" class="btn btn-white w-full text-left">Shop</a>
                        <a href="{{ route('shop.cart.index') }}" class="btn btn-white w-full text-left">Cart</a>
                        <a href="{{ route('shop.orders.index') }}" class="btn btn-white w-full text-left">Pesanan</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-white w-full text-left">Log Out</button>
                    </form>
                </div>
            @else
                <div class="pt-2">
                    <a href="{{ route('login') }}" class="btn btn-primary w-full">Login</a>
                </div>
            @endauth
        </div>
    </div>
</nav>

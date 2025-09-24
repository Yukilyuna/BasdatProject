<x-guest-layout>
    <div class="relative min-h-screen overflow-hidden">

        {{-- Background --}}
        <img src="{{ asset('images/login-bg.jpg') }}" alt="Login Background"
             class="absolute inset-0 -z-10 h-full w-full object-cover">
        <div class="absolute inset-0 -z-10 bg-gradient-to-b from-black/30 via-black/10 to-white/10"></div>

        {{-- Brand di pojok kiri atas --}}
        <a href="{{ route('home') }}" class="absolute left-6 top-6 z-20 drop-shadow">
        <x-brand variant="light" />
        </a>


        {{-- Center container --}}
        <div class="relative z-10 flex min-h-screen items-center justify-center px-4 py-10">
            <div class="w-full max-w-[420px] rounded-3xl bg-white/90 backdrop-blur ring-1 ring-black/5 shadow-xl p-8">

                <h1 class="mb-1 text-2xl font-semibold text-brand-800">Masuk</h1>
                <p class="mb-6 text-sm text-gray-600">Silakan login untuk melanjutkan.</p>

                {{-- Status Breeze --}}
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input id="email" name="email" type="email" autocomplete="username" autofocus required
                               value="{{ old('email') }}"
                               class="mt-1 block w-full rounded-xl border-gray-300 focus:border-brand-400 focus:ring-brand-300">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                               class="mt-1 block w-full rounded-xl border-gray-300 focus:border-brand-400 focus:ring-brand-300">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    {{-- Remember + Forgot --}}
                    <div class="flex items-center justify-between">
                        <label class="inline-flex items-center gap-2">
                            <input name="remember" type="checkbox"
                                   class="rounded border-gray-300 text-brand-600 focus:ring-brand-400">
                            <span class="text-sm text-gray-600 select-none">Ingat saya</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-brand-700 hover:underline">
                                Lupa password?
                            </a>
                        @endif
                    </div>

                    {{-- Submit --}}
                    <button
                        class="w-full inline-flex items-center justify-center rounded-xl bg-brand-500 px-4 py-3
                               font-semibold text-white shadow-soft transition hover:bg-brand-600">
                        Masuk
                    </button>
                </form>

                {{-- Register link (opsional) --}}
                @if (Route::has('register'))
                    <p class="mt-6 text-center text-sm text-gray-600">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="font-medium text-brand-700 hover:underline">Daftar</a>
                    </p>
                @endif
            </div>
        </div>
    </div>
</x-guest-layout>

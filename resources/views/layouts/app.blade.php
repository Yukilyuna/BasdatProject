<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Farmacheat') }}</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen font-sans bg-gradient-to-b from-brand-50 via-white to-brand-50 text-gray-800">
        <div class="min-h-screen">
            @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
        <header class="bg-white/70 backdrop-blur border-b">
            <div class="mx-auto max-w-7xl px-6 md:px-8 py-6 md:py-8">
            {{ $header }}
            </div>
        </header>
        @endisset

        <main class="mx-auto max-w-7xl px-6 md:px-8 py-8 md:py-12">
        {{ $slot }}
        </main>
        </div>
    </body>
</html>

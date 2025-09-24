@props(['variant' => 'dark']) {{-- 'dark' | 'light' --}}
@php
  $iconBase = 'grid place-items-center font-bold rounded-xl w-8 h-8';
  $textBase = 'font-display text-xl';
  $iconClass = $variant === 'light'
      ? 'bg-white/20 ring-1 ring-white/50 text-white'
      : 'bg-brand-500 text-white';
  $textClass = $variant === 'light' ? 'text-white' : 'text-gray-900';
@endphp

<div {{ $attributes->merge(['class' => 'flex items-center gap-2']) }}>
  <div class="{{ $iconBase }} {{ $iconClass }}">F</div>
  <span class="{{ $textBase }} {{ $textClass }}">Farmacheat</span>
</div>

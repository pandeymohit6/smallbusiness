@props(['module', 'size' => 'md'])

@php
    $sizes = [
        'sm' => 'w-8 h-8 text-lg',
        'md' => 'w-10 h-10 text-xl',
        'lg' => 'w-16 h-16 text-3xl',
    ];

    $classes = $sizes[$size] ?? $sizes['md'];
@endphp

<span {{ $attributes->merge(['class' => "{$classes} inline-flex shrink-0 items-center justify-center overflow-hidden rounded-lg bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-300"]) }}>
    @if ($module->hasLogoImage())
        <img src="{{ $module->getLogoUrl() }}" alt="{{ $module->title }}" class="h-full w-full object-contain">
    @else
        <iconify-icon icon="{{ $module->icon ?: 'lucide:box' }}" aria-hidden="true"></iconify-icon>
    @endif
</span>

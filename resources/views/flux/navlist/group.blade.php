@props([
    'expandable' => false,
    'expanded' => true,
    'heading' => null,
    'icon' => null,
    'active' => false,
])

<?php if ($expandable && $heading): ?>

<div 
    x-data="{ isOpen: @js($expanded) }"
    {{ $attributes->class([
        'group transition-colors rounded-lg',
        'bg-zinc-100 dark:bg-zinc-800/30' => $active,
    ]) }}
    data-flux-navlist-group
>
    <!-- Tombol toggle -->
    <button
        x-on:click="isOpen = !isOpen"
        type="button"
        @class([
            'flex h-10 w-full items-center rounded-lg transition-all duration-200',
            'text-zinc-700 hover:bg-zinc-800/10 hover:text-zinc-900' => !$active,
            'text-primary-600 dark:text-primary-400 font-semibold' => $active,
            'lg:h-8',
            'dark:text-white/90 dark:hover:bg-white/10' => !$active,
        ])
    >
        <div class="flex items-center ps-3 pe-2">
            @if($icon)
                <div class="mr-2 flex size-5 items-center justify-center">
                    {{ $icon }}
                </div>
            @endif
            
            <!-- Ikon panah animasi -->
            <svg 
                xmlns="http://www.w3.org/2000/svg" 
                class="size-[0.8rem] transition-transform duration-200"
                :class="{ 'rotate-0': isOpen, '-rotate-90': !isOpen }"
                fill="none" 
                viewBox="0 0 24 24" 
                stroke="currentColor"
            >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </div>

        <span class="text-sm font-medium leading-none">
            {{ $heading }}
        </span>
    </button>

    <!-- Area konten yang bisa di-expand -->
    <div 
        x-show="isOpen"
        x-collapse.duration.300ms
        class="relative"
    >
        <div class="space-y-1 ps-8 pb-1">
            <!-- Garis vertikal -->
            <div class="absolute inset-y-0 start-0 w-px bg-gradient-to-b from-zinc-200 via-zinc-200/50 to-zinc-200 dark:from-white/20 dark:via-white/10 dark:to-white/20"></div>
            {{ $slot }}
        </div>
    </div>
</div>

<?php elseif ($heading): ?>

<!-- Versi non-expandable dengan heading -->
<div {{ $attributes->class([
    'block space-y-1 transition-colors rounded-lg',
    'bg-zinc-100 dark:bg-zinc-800/30 p-1' => $active,
]) }}>
    <div class="px-3 py-2">
        <div class="text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
            {{ $heading }}
        </div>
    </div>

    <div class="space-y-1">
        {{ $slot }}
    </div>
</div>

<?php else: ?>

<!-- Versi paling sederhana -->
<div {{ $attributes->class([
    'block space-y-1 transition-colors rounded-lg',
    'bg-zinc-100 dark:bg-zinc-800/30 p-1' => $active,
]) }}>
    {{ $slot }}
</div>

<?php endif; ?>
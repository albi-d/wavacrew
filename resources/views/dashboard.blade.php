<x-layouts.app :title="__('Dashboard')">
    <div class="w-full px-4 sm:px-6 lg:px-8 py-6" wire:listen="goalDeleted, goalUpdated">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                {{ __('Dashboard') }}
            </h1>
            <p class="mt-2 text-lg text-gray-600 dark:text-gray-300">
                {{ __('Selamat datang kembali! Mari pantau kesehatan finansial Anda hari ini.') }}
            </p>
            <div class="mt-6 border-b border-gray-200 dark:border-gray-700"></div>
        </div>
        @livewire('dashboard-ringkasan')
        @livewire('goals.index')
        @livewire('transaksi-tetap-list')
        <livewire:transaksi-terbaru />
    </div>
</x-layouts.app>
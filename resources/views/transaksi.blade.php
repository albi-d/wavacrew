<x-layouts.app :title="__('Manajemen Transaksi')">
    <div class="w-full px-4 sm:px-6 lg:px-8 py-6">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-neutral-900 dark:text-neutral-100">
                {{ __('Manajemen Transaksi') }}
            </h1>
            <p class="mt-2 text-lg text-neutral-600 dark:text-neutral-300">
                {{ __('Kelola data transaksi keuangan Anda') }}
            </p>
            <div class="mt-6 border-b border-neutral-200 dark:border-neutral-700"></div>
        </div>

        <!-- Main Content -->
        <div class="space-y-8">
            <!-- Form Section -->
            <div class="bg-white dark:bg-neutral-800 shadow-sm rounded-lg p-6">
                <h2 class="text-xl font-semibold text-neutral-800 dark:text-neutral-100 mb-4">
                    {{ __('Tambah/Edit Transaksi') }}
                </h2>
                @livewire('transaksi-form')
            </div>

            <!-- List Section -->
            <div class="bg-white dark:bg-neutral-800 shadow-sm rounded-lg overflow-hidden">
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-neutral-800 dark:text-neutral-100 mb-4">
                        {{ __('Riwayat Transaksi') }}
                    </h2>
                    @livewire('transaksi-list')
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
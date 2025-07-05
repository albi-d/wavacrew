<x-layouts.app :title="__('Category Manager')">
    <div class="w-full px-4 sm:px-6 lg:px-8 py-6">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                {{ __('Manajemen Kategori') }}
            </h1>
            <p class="mt-2 text-lg text-gray-600 dark:text-gray-300">
                {{ __('Selamat datang di halaman manajemen kategori') }}
            </p>
            <div class="mt-6 border-b border-gray-200 dark:border-gray-700"></div>
        </div>

        <livewire:category-manager />
    </div>
</x-layouts.app>
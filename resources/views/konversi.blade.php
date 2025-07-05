<x-layouts.app :title="__('Konversi Mata Uang')">
    <div class="w-full px-4 sm:px-6 lg:px-8 py-6">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                </svg>
                {{ __('Konversi Mata Uang') }}
            </h1>
            <p class="mt-2 text-lg text-gray-600 dark:text-gray-300">
                {{ __('Konversi nilai mata uang anda untuk berbagai mata uang dunia') }}
            </p>
            <div class="mt-6 border-b border-gray-200 dark:border-gray-700"></div>
        </div>

        <livewire:currency-converter />
        @livewire('currency-history-list')
    </div>
</x-layouts.app>
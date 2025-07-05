<div
    class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm overflow-hidden border border-neutral-200 dark:border-neutral-700">
    <!-- Success Message -->
    @if (session()->has('message'))
        <div
            class="flex items-center p-4 mb-6 text-green-800 bg-green-50 dark:bg-green-900/20 dark:text-green-200 border-b border-green-200 dark:border-green-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 flex-shrink-0" viewBox="0 0 20 20"
                fill="currentColor">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd" />
            </svg>
            {{ session('message') }}
        </div>
    @endif

    <!-- Tab Navigation -->
    <div class="border-b border-neutral-200 dark:border-neutral-700">
        <nav class="flex -mb-px">
            <button type="button" wire:click="$set('activeTab', 'biasa')"
                class="{{ $activeTab === 'biasa' ? 'border-blue-500 text-blue-600 dark:text-blue-400 dark:border-blue-400' : 'border-transparent text-neutral-500 hover:text-neutral-700 hover:border-neutral-300 dark:text-neutral-400 dark:hover:text-neutral-300' }} flex-1 py-4 px-1 text-center border-b-2 font-medium text-sm transition duration-150 ease-in-out">
                <div class="flex items-center justify-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Transaksi Biasa</span>
                </div>
            </button>
            <button type="button" wire:click="$set('activeTab', 'tetap')"
                class="{{ $activeTab === 'tetap' ? 'border-blue-500 text-blue-600 dark:text-blue-400 dark:border-blue-400' : 'border-transparent text-neutral-500 hover:text-neutral-700 hover:border-neutral-300 dark:text-neutral-400 dark:hover:text-neutral-300' }} flex-1 py-4 px-1 text-center border-b-2 font-medium text-sm transition duration-150 ease-in-out">
                <div class="flex items-center justify-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <span>Transaksi Tetap</span>
                </div>
            </button>
        </nav>
    </div>

    <!-- Form Content -->
    <div class="p-6">
        @if (session()->has('error'))
            <div
                class="mb-4 p-4 bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 text-red-700 dark:text-red-300 rounded-lg">
                {{ session('error') }}
            </div>
        @endif
        <form wire:submit.prevent="{{ $activeTab === 'biasa' ? 'submit' : 'submitTetap' }}" class="space-y-6">
            @if ($activeTab === 'biasa')
                @include('partials.transaksi-biasa-form')
            @elseif ($activeTab === 'tetap')
                @include('partials.transaksi-tetap-form')
            @endif
        </form>
    </div>
</div>
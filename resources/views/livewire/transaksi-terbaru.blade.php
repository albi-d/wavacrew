<div wire:poll.visible.1000ms="refreshTransactions"
    class="p-4 sm:p-6 bg-white dark:bg-neutral-800 rounded-lg sm:rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-4 sm:mb-5">
        <h2 class="text-lg sm:text-xl font-semibold text-gray-800 dark:text-neutral-100">Transaksi Terbaru</h2>
        <div class="flex items-center justify-between sm:justify-end gap-2">
            <button wire:click="refreshTransactions"
                class="p-1 text-gray-500 hover:text-gray-700 dark:text-neutral-400 dark:hover:text-neutral-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
            </button>
            <a href="{{ route('transaksi') }}"
                class="text-sm font-medium text-blue-500 hover:text-blue-600 dark:text-blue-400 dark:hover:text-blue-300">
                Lihat Semua
            </a>
        </div>
    </div>

    <!-- Transaction List -->
    <ul class="divide-y divide-gray-200 dark:divide-neutral-700">
        @forelse($transactions as $transaksi)
            <li class="py-3 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 group px-2 rounded-lg transition-colors duration-150
                        {{ $transaksi->jenis === 'Pengeluaran' ?
            'hover:bg-red-100 dark:hover:bg-red-900/30' :
            'hover:bg-green-50 dark:hover:bg-green-900/20' }}">

                <!-- Left Content -->
                <div class="flex items-center min-w-0 flex-1">
                    <!-- Icon -->
                    <div class="flex-shrink-0 mr-3">
                        @if($transaksi->jenis === 'Pengeluaran')
                            <div class="p-1.5 sm:p-2 rounded-full bg-red-100 dark:bg-red-900/30 text-red-500 dark:text-red-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                </svg>
                            </div>
                        @else
                            <div
                                class="p-1.5 sm:p-2 rounded-full bg-green-100 dark:bg-green-900/30 text-green-500 dark:text-green-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Text Content -->
                    <div class="flex-1 min-w-0">
                        <p class="text-sm sm:text-base font-medium text-gray-900 dark:text-neutral-100 truncate">
                            {{ $transaksi->deskripsi }}
                        </p>
                        <div class="flex flex-wrap items-center gap-x-2 text-xs text-gray-500 dark:text-neutral-400 mt-1">
                            <span>{{ $transaksi->tanggal->format('d M Y') }}</span>
                            <span class="hidden sm:inline w-1 h-1 rounded-full bg-gray-400 dark:bg-neutral-500"></span>
                            <span class="capitalize">{{ $transaksi->jenis }}</span>
                            @if($transaksi->category)
                                <span class="hidden sm:inline w-1 h-1 rounded-full bg-gray-400 dark:bg-neutral-500"></span>
                                <span class="truncate">{{ $transaksi->category->name }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Amount -->
                <div class="sm:ml-4 flex-shrink-0 self-end sm:self-auto">
                    <span class="text-sm sm:text-base font-semibold {{ $transaksi->jenis === 'Pengeluaran' ?
            'text-red-500 dark:text-red-400' :
            'text-green-500 dark:text-green-400' }}">
                        {{ $transaksi->jenis === 'Pengeluaran' ? '-' : '' }}Rp{{ number_format($transaksi->jumlah, 0, ',', '.') }}
                    </span>
                </div>
            </li>
        @empty
            <li class="py-6 text-center text-gray-500 dark:text-neutral-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-gray-300 dark:text-neutral-600"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="mt-2 text-sm sm:text-base">Belum ada transaksi</p>
            </li>
        @endforelse
    </ul>
</div>
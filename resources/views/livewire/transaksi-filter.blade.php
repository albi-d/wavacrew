<div class="max-w-4xl mx-auto p-4">
    <!-- Filter Buttons -->
    <div class="flex flex-wrap gap-2 mb-6">
        <button wire:click="$set('filter', '')"
            class="px-4 py-2 rounded-full text-sm font-medium transition-all
                {{ $filter === '' ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-gray-300' }}">
            Semua
        </button>
        <button wire:click="$set('filter', 'Pemasukan')"
            class="px-4 py-2 rounded-full text-sm font-medium transition-all
                {{ $filter === 'Pemasukan' ? 'bg-green-100 text-green-800 border border-green-300 shadow-md dark:bg-green-900/30 dark:text-green-200' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-gray-300' }}">
            <span class="flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                </svg>
                Pemasukan
            </span>
        </button>
        <button wire:click="$set('filter', 'Pengeluaran')"
            class="px-4 py-2 rounded-full text-sm font-medium transition-all
                {{ $filter === 'Pengeluaran' ? 'bg-red-100 text-red-800 border border-red-300 shadow-md dark:bg-red-900/30 dark:text-red-200' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-gray-300' }}">
            <span class="flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
                Pengeluaran
            </span>
        </button>
    </div>

    @if ($transaksi->count())
        <!-- Transaction List -->
        <div class="space-y-3">
            @foreach ($transaksi as $item)
                <div
                    class="group relative p-4 rounded-xl border border-gray-200 hover:border-gray-300 dark:border-gray-700 dark:hover:border-gray-600 transition-colors duration-200 shadow-sm hover:shadow-md dark:bg-gray-800/50">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-start gap-3">
                            <!-- Transaction Icon -->
                            <div
                                class="mt-1 flex-shrink-0 rounded-lg p-2 {{ $item->jenis === 'Pemasukan' ? 'bg-green-100 text-green-600 dark:bg-green-900/50 dark:text-green-300' : 'bg-red-100 text-red-600 dark:bg-red-900/50 dark:text-red-300' }}">
                                @if($item->jenis === 'Pemasukan')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                    </svg>
                                @endif
                            </div>

                            <!-- Transaction Details -->
                            <div class="flex-1">
                                <div class="flex items-center gap-2">
                                    <h3 class="font-medium text-gray-900 dark:text-white">{{ $item->deskripsi }}</h3>
                                    @if($item->category)
                                        <span
                                            class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                            {{ $item->category->name }}
                                        </span>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                    {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}
                                </p>
                            </div>
                        </div>

                        <!-- Amount -->
                        <div class="text-right">
                            <p
                                class="text-lg font-semibold {{ $item->jenis === 'Pemasukan' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                {{ $item->jenis === 'Pemasukan' ? '+' : '-' }} Rp{{ number_format($item->jumlah, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $transaksi->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="flex flex-col items-center justify-center py-12 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 dark:text-gray-500" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M9 14h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Belum ada transaksi</h3>
            <p class="mt-1 text-gray-500 dark:text-gray-400">Mulai catat transaksi pertama Anda</p>
            @if($filter)
                <button wire:click="$set('filter', '')"
                    class="mt-4 text-sm text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300">
                    Lihat semua transaksi
                </button>
            @endif
        </div>
    @endif
</div>
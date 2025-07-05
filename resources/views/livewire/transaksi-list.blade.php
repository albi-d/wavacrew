<div class="mt-4">
    <!-- Responsive Filter Controls -->
    <div class="flex flex-col sm:flex-row gap-3 mb-4">
        <div class="w-full sm:w-auto">
            <input type="date" wire:model.debounce.500ms.live="filterTanggal"
                class="w-full px-3 py-2 border border-neutral-300 dark:border-neutral-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-neutral-700 dark:text-neutral-100">
        </div>
        <div class="w-full sm:w-auto">
            <input type="text" placeholder="Cari Kategori..." wire:model.debounce.500ms.live="filterKategori"
                class="w-full px-3 py-2 border border-neutral-300 dark:border-neutral-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-neutral-700 dark:text-neutral-100">
        </div>
    </div>

    <!-- Loading Indicator -->
    <div wire:loading
        class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 p-3 mb-4 rounded-md flex items-center">
        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-blue-800 dark:text-blue-200" xmlns="http://www.w3.org/2000/svg"
            fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor"
                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
            </path>
        </svg>
        Memproses...
    </div>

    <!-- Responsive Table Container -->
    <div class="overflow-x-auto bg-white dark:bg-neutral-800 rounded-lg shadow">
        <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
            <thead class="bg-neutral-50 dark:bg-neutral-700">
                <tr>
                    <th scope="col"
                        class="px-4 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-300 uppercase tracking-wider">
                        Tanggal
                    </th>
                    <th scope="col"
                        class="px-4 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-300 uppercase tracking-wider">
                        Kategori
                    </th>
                    <th scope="col"
                        class="px-4 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-300 uppercase tracking-wider hidden sm:table-cell">
                        Jenis
                    </th>
                    <th scope="col"
                        class="px-4 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-300 uppercase tracking-wider">
                        Jumlah
                    </th>
                    <th scope="col"
                        class="px-4 py-3 text-right text-xs font-medium text-neutral-500 dark:text-neutral-300 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-neutral-800 divide-y divide-neutral-200 dark:divide-neutral-700">
                @forelse ($transaksis as $t)
                    <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-700">
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                            {{ $t->tanggal->format('d-m-Y') }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                            {{ $t->category->name ?? '-' }}
                        </td>
                        <td
                            class="px-4 py-3 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100 hidden sm:table-cell">
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $t->jenis === 'Pemasukan' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200' }}">
                                {{ ucfirst($t->jenis) }}
                            </span>
                        </td>
                        <td
                            class="px-4 py-3 whitespace-nowrap text-sm 
                                        {{ $t->jenis === 'Pemasukan' ? 'text-green-600 dark:text-green-400 font-medium' : 'text-red-600 dark:text-red-400 font-medium' }}">
                            Rp{{ number_format($t->jumlah, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-right">
                            <div class="flex justify-end space-x-2">
                                <button wire:click="$dispatch('editTransaksi', { id: {{ $t->id }} })"
                                    class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 p-1 rounded hover:bg-blue-50 dark:hover:bg-neutral-600 transition-colors"
                                    title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button
                                    wire:confirm="Yakin hapus transaksi ini?"
                                    wire:click="delete({{ $t->id }})"
                                    class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 p-1 rounded hover:bg-red-50 dark:hover:bg-neutral-600 transition-colors"
                                    title="Hapus">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-sm text-neutral-500 dark:text-neutral-400">
                            Belum ada transaksi
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4 px-2 sm:px-0">
        {{ $transaksis->links() }}
    </div>
</div>
<div
    class="mx-auto p-6 bg-white rounded-xl shadow-sm dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-neutral-800 dark:text-neutral-100">Kelola Kategori</h2>
        <div class="text-sm text-neutral-500 dark:text-neutral-400">
            Total: {{ $categories->count() }} kategori
        </div>
    </div>

    <!-- Success Message -->
    @if (session()->has('message'))
        <div
            class="mb-6 flex items-center p-4 bg-green-50 text-green-700 rounded-lg dark:bg-green-900/20 dark:text-green-200 border border-green-100 dark:border-green-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd" />
            </svg>
            {{ session('message') }}
        </div>
    @endif

    <!-- Category Form -->
    <form wire:submit.prevent="{{ $editing ? 'update' : 'create' }}"
        class="mb-8 bg-neutral-50 dark:bg-neutral-700/30 p-5 rounded-xl">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
            <!-- Nama Kategori -->
            <div class="md:col-span-5">
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Nama
                    Kategori</label>
                <input type="text" wire:model="name" placeholder="Contoh: Belanja Bulanan" required
                    class="w-full px-4 py-2.5 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-neutral-700 dark:border-neutral-600 dark:text-neutral-100 dark:placeholder-neutral-400 transition">
            </div>

            <!-- Jenis Transaksi -->
            <div class="md:col-span-3">
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Jenis</label>
                <select wire:model="type"
                    class="w-full px-4 py-2.5 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-neutral-700 dark:border-neutral-600 dark:text-neutral-100 transition">
                    <option value="Pengeluaran">Pengeluaran</option>
                    <option value="Pemasukan">Pemasukan</option>
                </select>
            </div>

            <!-- Recurring Toggle -->
            <div class="md:col-span-2 flex flex-col items-center">
                <label class="text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Transaksi Tetap</label>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" wire:model="for_recurring" class="sr-only peer">
                    <div
                        class="w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-neutral-600 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-neutral-500 peer-checked:bg-blue-600">
                    </div>
                </label>
            </div>

            <!-- Action Buttons -->
            <div class="md:col-span-2 flex gap-2">
                <button type="submit"
                    class="w-full px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors dark:bg-blue-700 dark:hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-neutral-800 flex items-center justify-center text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    {{ $editing ? 'Update' : 'Tambah' }}
                </button>
                @if ($editing)
                    <button type="button" wire:click="resetForm"
                        class="px-3 py-2 border border-neutral-300 text-neutral-600 rounded-lg hover:bg-neutral-50 dark:border-neutral-600 dark:text-neutral-300 dark:hover:bg-neutral-700 transition-colors text-sm">
                        Batal
                    </button>
                @endif
            </div>
        </div>
    </form>

    <!-- Categories List -->
    <div class="border rounded-xl overflow-auto dark:border-neutral-700 shadow-xs">
        <ul class="divide-y divide-neutral-200 dark:divide-neutral-700">
            @forelse ($categories as $cat)
                    <li
                        class="flex items-center justify-between p-4 hover:bg-neutral-50 dark:hover:bg-neutral-700/50 transition">
                        <div class="flex items-center space-x-3">
                            <!-- Category Icon -->
                            <div class="flex-shrink-0 p-2 rounded-lg 
                                    {{ $cat->type === 'Pemasukan'
                ? 'bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-300'
                : 'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-300' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    @if($cat->type === 'Pemasukan')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    @endif
                                </svg>
                            </div>

                            <div>
                                <span class="font-medium text-neutral-800 dark:text-neutral-100">{{ $cat->name }}</span>
                                <div class="flex items-center space-x-2 mt-1">
                                    <span class="text-xs px-2 py-1 rounded-full 
                                            {{ $cat->type === 'Pemasukan'
                ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-200'
                : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-200' }}">
                                        {{ $cat->type }}
                                    </span>
                                    @if ($cat->for_recurring)
                                        <span
                                            class="text-xs px-2 py-1 rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-200">
                                            Tetap
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <button wire:click="edit({{ $cat->id }})"
                                class="p-2 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 rounded-full hover:bg-blue-50 dark:hover:bg-blue-900/20 transition"
                                title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                            <button wire:click="delete({{ $cat->id }})"
                                class="p-2 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 rounded-full hover:bg-red-50 dark:hover:bg-red-900/20 transition"
                                title="Hapus">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </li>
            @empty
                <li class="p-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-neutral-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-neutral-900 dark:text-neutral-100">Belum ada kategori</h3>
                    <p class="mt-1 text-neutral-500 dark:text-neutral-400">Mulai dengan menambahkan kategori baru</p>
                </li>
            @endforelse
        </ul>
    </div>
</div>
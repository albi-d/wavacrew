<div class="space-y-6">
    <!-- Date Range Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="tanggal" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">
                Tanggal Mulai
            </label>
            <input type="date" id="tanggal_mulai" wire:model="tanggal_mulai"
                class="w-full px-4 py-2.5 border border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-neutral-700 dark:text-neutral-100 transition">
        </div>
        <!-- Frequency Selection -->
        <div>
            <label for="frekuensi" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">
                Frekuensi
            </label>
            <select wire:model="frekuensi" id="frekuensi"
                class="w-full px-4 py-2.5 border border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-neutral-700 dark:text-neutral-100 transition">
                <option value="harian">Harian</option>
                <option value="mingguan">Mingguan</option>
                <option value="bulanan">Bulanan</option>
            </select>
        </div>
    </div>

    <!-- Jenis Transaksi -->
    <div>
        <label for="jenis" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">
            Jenis Transaksi
        </label>
        <select wire:model.live="jenisTetap" id="jenis"
            class="w-full px-3 py-2 border border-neutral-300 dark:border-neutral-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-neutral-700 dark:text-neutral-100">
            <option value="Pengeluaran">Pengeluaran</option>
            <option value="Pemasukan">Pemasukan</option>
        </select>
    </div>

    <!-- Category & Amount -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="category_id" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">
                Kategori
            </label>
            <select id="category_id" wire:model="category_id"
                class="w-full px-3 py-2 border border-neutral-300 dark:border-neutral-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-neutral-700 dark:text-neutral-100">
                <option value="">Pilih Kategori</option>
                @foreach ($categoriesBerulang as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="jumlah" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">
                Jumlah
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <span class="text-neutral-500 dark:text-neutral-400">Rp</span>
                </div>
                <input type="number" id="jumlah" wire:model="jumlah"
                    class="block w-full pl-10 pr-4 py-2.5 border border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-neutral-700 dark:text-neutral-100 transition"
                    placeholder="0">
            </div>
        </div>
    </div>

    <!-- Description -->
    <div>
        <label for="deskripsi" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">
            Deskripsi
        </label>
        <textarea id="deskripsi" wire:model="deskripsi" rows="3"
            class="w-full px-4 py-2.5 border border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-neutral-700 dark:text-neutral-100 transition"
            placeholder="Tambahkan deskripsi transaksi tetap..."></textarea>
    </div>

    <!-- Submit Button -->
    <div class="pt-2">
        <button wire:click="submitTetap"
            class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-neutral-800 transition duration-150 ease-in-out">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
            </svg>
            {{ $activeTab === 'tetap' && $editId ? 'Edit Transaksi Tetap' : 'Simpan Transaksi Tetap' }}
        </button>
    </div>
</div>
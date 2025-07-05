<!-- Date Input -->
<div>
    <label for="tanggal" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Tanggal</label>
    <input type="date" wire:model="tanggal" id="tanggal"
        class="w-full px-3 py-2 border border-neutral-300 dark:border-neutral-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-neutral-700 dark:text-neutral-100"
        required>
</div>

<!-- Type Selection -->
<div>
    <label for="jenis" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Jenis
        Transaksi</label>
    <select wire:model.live="jenis" id="jenis"
        class="w-full px-3 py-2 border border-neutral-300 dark:border-neutral-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-neutral-700 dark:text-neutral-100">
        <option value="Pengeluaran" class="dark:bg-neutral-700 dark:text-neutral-100">Pengeluaran</option>
        <option value="Pemasukan" class="dark:bg-neutral-700 dark:text-neutral-100">Pemasukan</option>
    </select>
</div>

<!-- Category Input -->
<div>
    <label for="category_id"
        class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Kategori</label>
    <select id="category_id" wire:model="category_id"
        class="w-full px-3 py-2 border border-neutral-300 dark:border-neutral-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-neutral-700 dark:text-neutral-100">
        <option value="" class="dark:bg-neutral-700 dark:text-neutral-100">Pilih Kategori</option>
        @foreach ($categories as $cat)
            <option value="{{ $cat->id }}" class="dark:bg-neutral-700 dark:text-neutral-100">{{ $cat->name }}</option>
        @endforeach
    </select>
</div>

<!-- Amount Input -->
<div>
    <label for="jumlah" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Jumlah
        (Rp)</label>
    <input type="number" wire:model="jumlah" id="jumlah" placeholder="0"
        class="w-full px-3 py-2 border border-neutral-300 dark:border-neutral-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-neutral-700 dark:text-neutral-100"
        required>
</div>

<!-- Description Textarea -->
<div>
    <label for="deskripsi" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Deskripsi
        (Opsional)</label>
    <textarea wire:model="deskripsi" id="deskripsi" rows="3"
        class="w-full px-3 py-2 border border-neutral-300 dark:border-neutral-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-neutral-700 dark:text-neutral-100"
        placeholder="Tambahkan deskripsi transaksi..."></textarea>
</div>

<!-- Action Buttons -->
<div class="flex items-center space-x-3 pt-2">
    <button type="submit"
        class="px-4 py-2 bg-blue-600 dark:bg-blue-700 text-white rounded-md hover:bg-blue-700 dark:hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-neutral-800 transition-colors">
        @if($editId)
            Update Transaksi
        @else
            Simpan Transaksi
        @endif
    </button>

    @if ($editId)
        <button type="button" wire:click="resetForm"
            class="px-4 py-2 bg-neutral-200 dark:bg-neutral-600 text-neutral-700 dark:text-neutral-200 rounded-md hover:bg-neutral-300 dark:hover:bg-neutral-500 focus:outline-none focus:ring-2 focus:ring-neutral-500 focus:ring-offset-2 dark:focus:ring-offset-neutral-800 transition-colors">
            Batal Edit
        </button>
    @endif
</div>
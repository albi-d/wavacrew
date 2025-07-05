<div class="max-w-2xl mx-auto p-6 bg-white dark:bg-neutral-800 rounded-lg shadow-md transition-colors duration-300">
    <h2 class="text-2xl font-semibold text-gray-800 dark:text-neutral-100 mb-6">
        {{ $goalId ? 'Edit Target Keuangan' : 'Tambah Target Keuangan' }}
    </h2>

    <form wire:submit.prevent="save" class="space-y-6">
        <!-- Nama Tujuan -->
        <div class="space-y-2">
            <label for="nama" class="block text-sm font-medium text-gray-700 dark:text-neutral-300">Nama Target</label>
            <input type="text" id="nama" wire:model.defer="nama"
                class="w-full px-4 py-2 border border-gray-300 dark:border-neutral-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition bg-white dark:bg-neutral-700 text-neutral-900 dark:text-neutral-100 placeholder-gray-400 dark:placeholder-neutral-400"
                placeholder="Contoh: Liburan ke Bali" />
            @error('nama')
                <span class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span>
            @enderror
        </div>

        <!-- Target Dana -->
        <div class="space-y-2">
            <label for="target" class="block text-sm font-medium text-gray-700 dark:text-neutral-300">Target Dana
                (Rp)</label>
            <div class="relative">
                <span class="absolute left-3 top-2.5 text-gray-500 dark:text-neutral-400">Rp</span>
                <input type="number" id="target" wire:model.defer="target"
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-neutral-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition bg-white dark:bg-neutral-700 text-neutral-900 dark:text-neutral-100 placeholder-gray-400 dark:placeholder-neutral-400"
                    placeholder="10.000.000" />
            </div>
            @error('target')
                <span class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span>
            @enderror
        </div>

        <!-- Tenggat Waktu -->
        <div class="space-y-2">
            <label for="deadline" class="block text-sm font-medium text-gray-700 dark:text-neutral-300">Tenggat
                Waktu</label>
            <input type="date" id="deadline" wire:model.defer="deadline"
                class="w-full px-4 py-2 border border-gray-300 dark:border-neutral-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition bg-white dark:bg-neutral-700 text-neutral-900 dark:text-neutral-100"
                min="{{ date('Y-m-d') }}" />
            @error('deadline')
                <span class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit"
            class="w-full bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-600 text-white font-medium py-2.5 px-4 rounded-md transition duration-200 ease-in-out shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-neutral-800 transform hover:-translate-y-0.5">
            {{ $goalId ? 'Perbarui Target' : 'Simpan Target' }}
        </button>

        <!-- Back Link -->
        <div class="mt-4 text-center">
            <a href="{{ route('dashboard') }}"
                class="text-sm text-blue-600 dark:text-blue-400 hover:underline hover:text-blue-800 dark:hover:text-blue-300 transition-colors">
                Kembali ke Dashboard
            </a>
        </div>
    </form>
</div>
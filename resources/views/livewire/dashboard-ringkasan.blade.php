<div>
    <!-- Filter Section -->
    <div class="mb-6 flex flex-wrap items-end gap-4">
        <!-- Month Selector -->
        <div class="flex-1 min-w-[150px]">
            <label class="block text-sm font-medium text-gray-700 dark:text-neutral-300 mb-1">Bulan</label>
            <div class="relative">
                <select wire:model.live="bulan"
                    class="block w-full px-3 py-2 border border-gray-300 dark:border-neutral-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-neutral-700 dark:text-white transition-all duration-200 appearance-none">
                    @for ($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" class="dark:bg-gray-700 dark:text-white">
                            {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                        </option>
                    @endfor
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400 dark:text-neutral-300" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Year Selector -->
        <div class="flex-1 min-w-[150px]">
            <label class="block text-sm font-medium text-gray-700 dark:text-neutral-300 mb-1">Tahun</label>
            <div class="relative">
                <select wire:model.live="tahun"
                    class="block w-full px-3 py-2 border border-gray-300 dark:border-neutral-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-neutral-700 dark:text-white transition-all duration-200 appearance-none">
                    @for ($y = now()->year; $y >= now()->year - 5; $y--)
                        <option value="{{ $y }}" class="dark:bg-gray-700 dark:text-white">{{ $y }}</option>
                    @endfor
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Income Card -->
        <div wire:click="redirectToTransaksi('Pemasukan')"
            class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900 dark:to-green-800 p-6 rounded-xl shadow-lg border border-green-200 dark:border-green-700 hover:shadow-md transition-shadow duration-300 cursor-pointer">
            <div class="flex items-center justify-between">
                <h2 class="text-green-700 dark:text-green-200 font-semibold text-lg">Total Pemasukan</h2>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-500 dark:text-green-300" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                </svg>
            </div>
            <div class="flex items-center gap-2 mt-3 min-h-[48px] tooltip tooltip-top tooltip-success"
                data-tip="Total Keseluruhan: Rp{{ number_format($totalPemasukanAll, 0, ',', '.') }}">
                <p class="text-3xl font-bold text-green-800 dark:text-green-100 truncate max-w-[calc(100%-30px)]"
                    style="font-size: clamp(1.25rem, 5vw, 1.8rem);">
                    Rp{{ number_format($totalPemasukan, 0, ',', '.') }}
                </p>
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-600 dark:text-green-300" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z" />
                    </svg>
                </div>
            </div>
            <div
                class="mt-4 pt-3 border-t border-green-200 dark:border-green-700 text-sm text-green-600 dark:text-green-300">
                <span class="inline-flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Updated today
                </span>
            </div>
        </div>

        <!-- Expense Card -->
        <div wire:click="redirectToTransaksi('Pengeluaran')"
            class="bg-gradient-to-br from-red-50 to-red-100 dark:from-red-900 dark:to-red-800 p-6 rounded-xl shadow-lg border border-red-200 dark:border-red-700 hover:shadow-md transition-shadow duration-300 cursor-pointer">
            <div class="flex items-center justify-between">
                <h2 class="text-red-700 dark:text-red-200 font-semibold text-lg">Total Pengeluaran</h2>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-500 dark:text-red-300" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
            </div>
            <div class="flex items-center gap-2 mt-3 min-h-[48px] tooltip tooltip-bottom tooltip-error"
                data-tip="Total Keseluruhan: Rp{{ number_format($totalPengeluaranAll, 0, ',', '.') }}">
                <p class="text-3xl font-bold text-red-800 dark:text-red-100 truncate max-w-[calc(100%-30px)]"
                    style="font-size: clamp(1.25rem, 5vw, 1.8rem);">
                    Rp{{ number_format($totalPengeluaran, 0, ',', '.') }}
                </p>
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-600 dark:text-red-300" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-red-200 dark:border-red-700 text-sm text-red-600 dark:text-red-300">
                <span class="inline-flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Updated today
                </span>
            </div>
        </div>

        <!-- Balance Card -->
        <div
            class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900 dark:to-blue-800 p-6 rounded-xl shadow-lg border border-blue-200 dark:border-blue-700 hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <h2 class="text-blue-700 dark:text-blue-200 font-semibold text-lg">Sisa Saldo</h2>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500 dark:text-blue-300" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="flex items-center gap-2 mt-3 min-h-[48px] tooltip tooltip-top tooltip-primary"
                data-tip="Total Keseluruhan: Rp{{ number_format($saldoAll, 0, ',', '.') }}">
                <p class="text-3xl font-bold text-blue-800 dark:text-blue-100 truncate max-w-[calc(100%-30px)]"
                    style="font-size: clamp(1.25rem, 5vw, 1.8rem);">
                    Rp{{ number_format($saldo, 0, ',', '.') }}
                </p>
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-600 dark:text-blue-300" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z" />
                    </svg>
                </div>
            </div>
            <div
                class="mt-4 pt-3 border-t border-blue-200 dark:border-blue-700 text-sm text-blue-600 dark:text-blue-300">
                <span class="inline-flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Current balance
                </span>
            </div>
        </div>
    </div>
</div>
<div class="bg-white dark:bg-neutral-800 rounded-lg shadow-md p-4 mt-4 border border-neutral-200 dark:border-neutral-700">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-bold text-neutral-800 dark:text-neutral-200">Riwayat Konversi</h2>
        @if($histories->count() > 0)
            <span
                class="text-xs bg-neutral-200 text-neutral-800 dark:bg-neutral-700 dark:text-neutral-300 px-2 py-1 rounded-full">
                {{ $histories->count() }} konversi
            </span>
        @endif
    </div>

    @if($histories->count() > 0)
        <div class="space-y-3">
            @foreach ($histories as $history)
                <div
                    class="flex items-center p-3 bg-neutral-50 dark:bg-neutral-700 rounded-lg hover:bg-neutral-100 dark:hover:bg-neutral-600 transition-colors duration-200">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-neutral-200 dark:bg-neutral-600 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-neutral-600 dark:text-neutral-300"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-neutral-800 dark:text-neutral-200">
                                {{ number_format($history->amount, 2) }} {{ $history->from_currency }}
                                <span class="mx-1">→</span>
                                <span class="font-semibold text-neutral-700 dark:text-neutral-300">
                                    {{ number_format($history->converted_amount, 2) }} {{ $history->to_currency }}
                                </span>
                            </p>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 flex items-center mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ \Carbon\Carbon::parse($history->converted_at)->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-8">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-neutral-400 dark:text-neutral-500"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-neutral-600 dark:text-neutral-300">Belum ada riwayat konversi</h3>
            <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">Konversi mata uang akan muncul di sini</p>
        </div>
    @endif
</div>
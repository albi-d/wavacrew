<div class="mt-6 sm:mt-8">
    <!-- Main Card Container -->
    <div
        class="bg-white dark:bg-neutral-800 rounded-lg sm:rounded-xl shadow-sm border border-neutral-200 dark:border-neutral-700 p-4 sm:p-6 mb-6 sm:mb-8">
        <!-- Header Section -->
        <div
            class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-4 mb-4 sm:mb-6 pb-4 border-b border-neutral-100 dark:border-neutral-700">
            <div>
                <h2 class="text-lg sm:text-xl font-bold text-neutral-800 dark:text-white">Target Keuangan</h2>
                <p class="mt-1 text-xs sm:text-sm text-neutral-600 dark:text-neutral-300">Kelola target keuangan untuk
                    mencapai impian Anda</p>
            </div>
            <div class="flex items-center gap-2 sm:gap-4 w-full sm:w-auto">
                <span
                    class="px-2 sm:px-3 py-0.5 sm:py-1 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-200 text-xs sm:text-sm font-medium rounded-full">
                    Total: {{ $goals->count() }} target
                </span>
                <a href="{{ route('goal') }}"
                    class="flex items-center gap-1 px-3 py-1.5 sm:px-4 sm:py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs sm:text-sm font-medium rounded-lg transition-all w-full sm:w-auto justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="hidden sm:inline">Tambah Baru</span>
                    <span class="sm:hidden">Tambah</span>
                </a>
            </div>
        </div>

        <!-- Notification Messages -->
        @if (session()->has('success'))
            <div
                class="mb-4 sm:mb-6 p-3 sm:p-4 bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 rounded-lg shadow-xs flex items-start">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4 sm:h-5 sm:w-5 text-green-500 dark:text-green-300 mt-0.5 mr-2 sm:mr-3 flex-shrink-0"
                    viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <div>
                    <p class="text-xs sm:text-sm font-medium text-green-800 dark:text-green-200">{{ session('success') }}
                    </p>
                </div>
            </div>
        @endif

        @if (session()->has('error'))
            <div
                class="mb-4 sm:mb-6 p-3 sm:p-4 bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 rounded-lg shadow-xs flex items-start">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4 sm:h-5 sm:w-5 text-red-500 dark:text-red-300 mt-0.5 mr-2 sm:mr-3 flex-shrink-0"
                    viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                        clip-rule="evenodd" />
                </svg>
                <div>
                    <p class="text-xs sm:text-sm font-medium text-red-800 dark:text-red-200">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <!-- Goals List -->
        <div class="space-y-3 sm:space-y-4">
            @forelse($goals as $goal)
                <div
                    class="bg-white dark:bg-neutral-800 rounded-lg shadow-xs border border-neutral-100 dark:border-neutral-700 overflow-hidden hover:shadow-sm transition-shadow">
                    <!-- Card Header -->
                    <div
                        class="px-4 py-2 sm:px-5 sm:py-3 border-b border-neutral-100 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-700/30 flex items-center justify-between">
                        <div class="flex items-center gap-2 overflow-hidden">
                            <h3 class="text-sm sm:text-base font-semibold text-neutral-800 dark:text-white truncate">
                                {{ $goal->nama }}</h3>
                            <span class="px-1.5 py-0.5 rounded-full text-xs font-medium 
                                        @if($goal->terkumpul >= $goal->target) bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-200
                                        @elseif(\Carbon\Carbon::parse($goal->deadline)->isPast()) bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-200
                                        @else bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-200 @endif">
                                @if($goal->terkumpul >= $goal->target) Tercapai
                                @elseif(\Carbon\Carbon::parse($goal->deadline)->isPast()) Deadline Lewat
                                @else Berjalan @endif
                            </span>
                        </div>
                        <div class="flex items-center gap-1 sm:gap-2">
                            <a href="{{ route('goal', ['goal_id' => $goal->id]) }}"
                                class="p-1 sm:p-2 text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 rounded-lg hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition"
                                title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <button wire:click="confirmDelete({{ $goal->id }})"
                                class="p-1 sm:p-2 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition"
                                title="Hapus">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                            <button wire:click="openDistribusiModal({{ $goal->id }})"
                                class="p-1 sm:p-2 text-purple-600 hover:text-purple-800 dark:text-purple-400 dark:hover:text-purple-300 rounded-lg hover:bg-purple-50 dark:hover:bg-purple-900/20 transition"
                                title="Distribusi Manual">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Card Content -->
                    <div class="p-4 sm:p-5">
                        <!-- Progress Bar -->
                        <div class="mb-3 sm:mb-4">
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-xs sm:text-sm font-medium text-neutral-700 dark:text-neutral-300">
                                    Progress: {{ number_format(min(100, ($goal->terkumpul / $goal->target) * 100), 0) }}%
                                </span>
                                <span class="text-xs sm:text-sm font-medium text-neutral-700 dark:text-neutral-300">
                                    Rp{{ number_format($goal->terkumpul, 0, ',', '.') }} /
                                    Rp{{ number_format($goal->target, 0, ',', '.') }}
                                </span>
                            </div>
                            <div class="w-full bg-neutral-200 dark:bg-neutral-700 rounded-full h-2">
                                @php
                                    $progressPercentage = ($goal->target > 0)
                                        ? min(100, ($goal->terkumpul / $goal->target) * 100)
                                        : 0;
                                @endphp
                                <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ $progressPercentage }}%"></div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6">
                            <!-- Target Info -->
                            <div class="space-y-1">
                                <p
                                    class="text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                                    Target</p>
                                <p class="text-base sm:text-lg font-semibold text-neutral-900 dark:text-white">
                                    Rp{{ number_format($goal->target, 0, ',', '.') }}
                                </p>
                            </div>

                            <!-- Deadline -->
                            <div class="space-y-1">
                                <p
                                    class="text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                                    Deadline</p>
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-4 w-4 sm:h-5 sm:w-5 text-neutral-400 dark:text-neutral-500" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="text-base sm:text-lg font-medium text-neutral-900 dark:text-white">
                                        {{ \Carbon\Carbon::parse($goal->deadline)->translatedFormat('d M Y') }}
                                        @php
                                            $deadline = \Carbon\Carbon::parse($goal->deadline);
                                            $now = now();
                                            $isPast = $deadline->isPast();
                                            $daysRemaining = $now->diffInDays($deadline, false);
                                            $monthsRemaining = $now->diffInMonths($deadline, false);
                                        @endphp

                                        @if($isPast)
                                            <span
                                                class="ml-1 sm:ml-2 text-xs px-1 py-0.5 bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-200 rounded-full">Lewat</span>
                                        @elseif($daysRemaining <= 7)
                                            <span
                                                class="ml-1 sm:ml-2 text-xs px-1 py-0.5 bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-200 rounded-full">{{ round($daysRemaining) }}
                                                hari</span>
                                        @elseif($daysRemaining <= 30)
                                            <span
                                                class="ml-1 sm:ml-2 text-xs px-1 py-0.5 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-200 rounded-full">{{ round($daysRemaining) }}
                                                hari</span>
                                        @elseif($monthsRemaining <= 12)
                                            <span
                                                class="ml-1 sm:ml-2 text-xs px-1 py-0.5 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-200 rounded-full">{{ round($monthsRemaining) }}
                                                bln</span>
                                        @else
                                            <span
                                                class="ml-1 sm:ml-2 text-xs px-1 py-0.5 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-200 rounded-full">Lama</span>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <!-- Remaining -->
                            <div class="space-y-1">
                                <p
                                    class="text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                                    Sisa</p>
                                <p
                                    class="text-base sm:text-lg font-semibold {{ ($goal->target - $goal->terkumpul) > 0 ? 'text-red-600 dark:text-red-300' : 'text-green-600 dark:text-green-300' }}">
                                    Rp{{ number_format($goal->target - $goal->terkumpul, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div
                    class="bg-white dark:bg-neutral-800 rounded-lg sm:rounded-xl shadow-xs border border-neutral-100 dark:border-neutral-700 p-6 sm:p-8 text-center">
                    <div class="mx-auto max-w-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-10 sm:h-12 w-10 sm:w-12 text-neutral-400"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <h3 class="mt-2 sm:mt-3 text-base sm:text-lg font-medium text-neutral-900 dark:text-white">Belum ada
                            target keuangan</h3>
                        <p class="mt-1 sm:mt-2 text-xs sm:text-sm text-neutral-500 dark:text-neutral-400">Mulai dengan
                            menambahkan target keuangan baru untuk mengelola tujuan finansial Anda.</p>
                        <div class="mt-4 sm:mt-6">
                            <a href="{{ route('goal') }}"
                                class="inline-flex items-center px-3 py-1.5 sm:px-4 sm:py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs sm:text-sm font-medium rounded-lg transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 mr-1 sm:mr-2"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                Tambah Target
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    @if ($confirmingDelete)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 backdrop-blur-sm">
            <div class="fixed inset-0 bg-black/50 transition-opacity" wire:click="cancelDelete"></div>

            <div
                class="relative w-full max-w-xs sm:max-w-md rounded-lg sm:rounded-xl bg-white p-4 sm:p-6 shadow-2xl dark:bg-neutral-800 dark:shadow-neutral-900/50">
                <!-- Header -->
                <div class="mb-3 sm:mb-4 flex items-start justify-between">
                    <div>
                        <h2 class="text-lg sm:text-xl font-bold text-neutral-800 dark:text-white">Konfirmasi Hapus Target
                        </h2>
                        <p class="text-xs sm:text-sm text-neutral-500 dark:text-neutral-400">Tindakan ini tidak dapat
                            dibatalkan</p>
                    </div>
                    <button wire:click="cancelDelete"
                        class="rounded-md p-1 text-neutral-400 hover:bg-neutral-100 hover:text-neutral-500 dark:hover:bg-neutral-700 dark:hover:text-neutral-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Goal Details -->
                <div
                    class="mb-3 sm:mb-4 space-y-2 sm:space-y-3 rounded-lg border bg-neutral-50 p-3 sm:p-4 dark:border-neutral-700 dark:bg-neutral-700/50">
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm sm:text-base font-medium text-neutral-800 dark:text-white truncate">
                            {{ $goalDetails['nama'] }}</h3>
                        <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium 
                                    @if($goalDetails['sudahTercapai']) bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-200
                                    @elseif($goalDetails['sudahLewat']) bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-200
                                    @else bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-200 @endif">
                            @if($goalDetails['sudahTercapai']) Tercapai
                            @elseif($goalDetails['sudahLewat']) Deadline Lewat
                            @else Berjalan @endif
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-3 sm:gap-4 text-xs sm:text-sm">
                        <div>
                            <p class="text-neutral-500 dark:text-neutral-400">Target</p>
                            <p class="font-medium text-neutral-800 dark:text-white">
                                Rp{{ number_format($goalDetails['target']) }}</p>
                        </div>
                        <div>
                            <p class="text-neutral-500 dark:text-neutral-400">Terkumpul</p>
                            <p class="font-medium text-neutral-800 dark:text-white">
                                Rp{{ number_format($goalDetails['terkumpul']) }}</p>
                        </div>
                        <div>
                            <p class="text-neutral-500 dark:text-neutral-400">Deadline</p>
                            <p class="font-medium text-neutral-800 dark:text-white">
                                {{ \Carbon\Carbon::parse($goalDetails['deadline'])->translatedFormat('d M Y') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-neutral-500 dark:text-neutral-400">Sisa</p>
                            <p class="font-medium text-neutral-800 dark:text-white">
                                Rp{{ number_format($goalDetails['target'] - $goalDetails['terkumpul']) }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Warning Message -->
                <div
                    class="mb-4 sm:mb-6 p-3 sm:p-4 bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 rounded-lg shadow-xs flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4 sm:h-5 sm:w-5 text-red-500 dark:text-red-300 mt-0.5 mr-2 sm:mr-3 flex-shrink-0"
                        viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                    <div>
                        <p class="text-xs sm:text-sm font-medium text-red-800 dark:text-red-200">Dana yang terkumpul
                            (Rp{{ number_format($goalDetails['terkumpul']) }}) akan dikembalikan ke saldo Anda.</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-2 sm:space-x-3">
                    <button wire:click="cancelDelete"
                        class="rounded-lg border border-neutral-300 px-3 py-1.5 sm:px-4 sm:py-2.5 text-xs sm:text-sm font-medium text-neutral-700 hover:bg-neutral-50 focus:outline-none focus:ring-2 focus:ring-neutral-500 focus:ring-offset-2 dark:border-neutral-600 dark:text-neutral-300 dark:hover:bg-neutral-700">
                        Batal
                    </button>
                    <button wire:click="deleteGoal"
                        class="rounded-lg bg-red-600 px-3 py-1.5 sm:px-4 sm:py-2.5 text-xs sm:text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:bg-red-700 dark:hover:bg-red-800">
                        Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if ($showModalDistribusi)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 backdrop-blur-sm">
            <div class="fixed inset-0 bg-black/50 transition-opacity" wire:click="$set('showModalDistribusi', false)"></div>

            <div
                class="relative w-full max-w-xs sm:max-w-md rounded-xl sm:rounded-2xl bg-white p-4 sm:p-6 shadow-xl dark:bg-neutral-800 dark:shadow-neutral-900/50">
                <!-- Header -->
                <div class="mb-4 sm:mb-6 flex items-start justify-between">
                    <div class="flex items-start gap-2 sm:gap-3">
                        <div
                            class="mt-1 p-1.5 sm:p-2 rounded-lg bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg sm:text-xl font-bold text-neutral-800 dark:text-white">Salurkan Dana</h2>
                            <p class="text-xs sm:text-sm text-neutral-500 dark:text-neutral-400">
                                Ke target: <span
                                    class="font-medium text-neutral-700 dark:text-neutral-300">{{ $selectedGoalName ?? 'Target tidak ditemukan' }}</span>
                            </p>
                        </div>
                    </div>
                    <button wire:click="$set('showModalDistribusi', false)"
                        class="rounded-lg p-1 sm:p-1.5 text-neutral-400 hover:bg-neutral-100 hover:text-neutral-500 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Input Section -->
                <div class="mb-4 sm:mb-6">
                    <label for="jumlahDistribusi"
                        class="block text-xs sm:text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1 sm:mb-2">
                        Jumlah yang akan disalurkan
                    </label>
                    <div class="relative rounded-lg shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-neutral-500 dark:text-neutral-400 text-sm sm:text-base">Rp</span>
                        </div>
                        <input type="number" id="jumlahDistribusi" wire:model.defer="jumlahDistribusi"
                            class="block w-full pl-9 sm:pl-10 pr-12 py-2 sm:py-3 text-sm sm:text-base border border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-neutral-700 dark:text-white dark:focus:ring-indigo-600 dark:focus:border-indigo-600"
                            placeholder="0" inputmode="numeric" pattern="[0-9]*" step="1000" min="0"
                            max="{{ $availableBalance }}" autofocus />
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <span class="text-neutral-500 dark:text-neutral-400 text-sm sm:text-base">,00</span>
                        </div>
                    </div>
                    @error('jumlahDistribusi')
                        <p class="mt-1 text-xs sm:text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror

                    <!-- Balance Info -->
                    <div class="mt-3 sm:mt-4 space-y-1 sm:space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="text-xs sm:text-sm text-neutral-600 dark:text-neutral-400">Saldo tersedia bulan
                                ini:</span>
                            <span
                                class="text-xs sm:text-sm font-medium text-neutral-800 dark:text-neutral-200">Rp{{ number_format($availableBalance, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-xs sm:text-sm text-neutral-600 dark:text-neutral-400">Sisa kebutuhan:</span>
                            <span
                                class="text-xs sm:text-sm font-medium text-neutral-800 dark:text-neutral-200">Rp{{ number_format($remainingNeed, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end gap-2 sm:gap-3">
                    <button wire:click="$set('showModalDistribusi', false)"
                        class="px-3 py-1.5 sm:px-4 sm:py-2.5 text-xs sm:text-sm font-medium text-neutral-700 dark:text-neutral-300 bg-neutral-100 dark:bg-neutral-700 rounded-lg hover:bg-neutral-200 dark:hover:bg-neutral-600 transition-colors">
                        Batal
                    </button>
                    <button wire:click="salurkanSaldo"
                        class="px-3 py-1.5 sm:px-4 sm:py-2.5 text-xs sm:text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-neutral-800 transition-colors flex items-center gap-1 sm:gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                        Salurkan
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
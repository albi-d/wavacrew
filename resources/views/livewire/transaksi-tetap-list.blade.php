<div class="mt-6 sm:mt-8">
    <!-- Main Card Container -->
    <div class="bg-white dark:bg-neutral-800 rounded-lg sm:rounded-xl shadow-sm border border-neutral-200 dark:border-neutral-700 p-4 sm:p-6 mb-6 sm:mb-8">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-4 mb-4 sm:mb-6 pb-4 border-b border-neutral-100 dark:border-neutral-700">
            <div>
                <h2 class="text-lg sm:text-xl font-bold text-neutral-800 dark:text-white">Biaya Tetap</h2>
                <p class="mt-1 text-xs sm:text-sm text-neutral-600 dark:text-neutral-300">Kelola transaksi rutin bulanan Anda</p>
            </div>
            <div class="flex items-center gap-2 sm:gap-4 w-full sm:w-auto">
                <span class="px-2 sm:px-3 py-0.5 sm:py-1 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-200 text-xs sm:text-sm font-medium rounded-full">
                    Total: {{ $fixeds->count() }} transaksi
                </span>
                <a href="{{ route('transaksi', ['tambah_tetap' => true]) }}" class="flex items-center gap-1 px-3 py-1.5 sm:px-4 sm:py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs sm:text-sm font-medium rounded-lg transition-all shadow-sm hover:shadow-md w-full sm:w-auto justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    <span class="hidden sm:inline">Tambah Baru</span>
                    <span class="sm:hidden">Tambah</span>
                </a>
            </div>
        </div>

        <!-- Notification Messages -->
        @if (session()->has('message'))
            <div class="mb-4 sm:mb-6 p-3 sm:p-4 bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 rounded-lg shadow-xs flex items-start">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 text-green-500 dark:text-green-300 mt-0.5 mr-2 sm:mr-3 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <div>
                    <p class="text-xs sm:text-sm font-medium text-green-800 dark:text-green-200">{{ session('message') }}</p>
                </div>
            </div>
        @endif

        @php
            // Optimasi: Hitung sekali di awal
            $notifPengeluaran = collect($this->notifikasiJatuhTempo)->where('jenis', 'Pengeluaran');
            $notifPemasukan = collect($this->notifikasiJatuhTempo)->where('jenis', 'Pemasukan');
            $pemasukans = $fixeds->where('jenis', 'Pemasukan');
            $pengeluarans = $fixeds->where('jenis', 'Pengeluaran');
        @endphp

        <div wire:ignore.self>
            {{-- Notifikasi untuk Pengeluaran --}}
            @if ($notifPengeluaran->count() > 0)
                <div class="mb-4 sm:mb-6 p-3 sm:p-4 bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-400 rounded-lg shadow-xs">
                    <div class="flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 text-yellow-500 dark:text-yellow-300 mt-0.5 mr-2 sm:mr-3 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        <div>
                            <h3 class="text-xs sm:text-sm font-semibold text-yellow-800 dark:text-yellow-200">Perhatian: Pengeluaran Jatuh Tempo</h3>
                            <div class="mt-1 text-xs sm:text-sm text-yellow-700 dark:text-yellow-300">
                                <p>Beberapa transaksi *pengeluaran tetap* sudah mendekati atau melewati tanggal jatuh tempo:</p>
                                <ul class="mt-2 space-y-1">
                                    @foreach ($notifPengeluaran as $notif)
                                        <li class="flex items-start">
                                            <span class="inline-block w-2 h-2 mt-1.5 mr-2 bg-yellow-400 rounded-full flex-shrink-0"></span>
                                            <div>
                                                <span class="font-medium">{{ $notif['nama_kategori'] }}</span>
                                                <span class="block text-2xs sm:text-xs {{ $notif['text_class'] }}" 
                                                    data-due-date="{{ \Carbon\Carbon::parse($notif['tanggal_berikutnya'])->format('Y-m-d H:i:s') }}"
                                                    data-timezone="{{ config('app.timezone') }}">
                                                    Jatuh tempo: {{ \Carbon\Carbon::parse($notif['tanggal_berikutnya'])->format('Y-m-d') }}
                                                </span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div wire:ignore.self>
            {{-- Notifikasi untuk Pemasukan --}}
            @if ($notifPemasukan->count() > 0)
                <div class="mb-4 sm:mb-6 p-3 sm:p-4 bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-400 rounded-lg shadow-xs">
                    <div class="flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 text-blue-500 dark:text-blue-300 mt-0.5 mr-2 sm:mr-3 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 13a1 1 0 01-1 1h-5v3a1 1 0 01-2 0v-3H5a1 1 0 010-2h5V9a1 1 0 012 0v3h5a1 1 0 011 1z" clip-rule="evenodd" />
                        </svg>
                        <div>
                            <h3 class="text-xs sm:text-sm font-semibold text-blue-800 dark:text-blue-200">Pengingat: Jadwal Pemasukan</h3>
                            <div class="mt-1 text-xs sm:text-sm text-blue-700 dark:text-blue-300">
                                <p>Berikut pemasukan tetap yang dijadwalkan dalam waktu dekat:</p>
                                <ul class="mt-2 space-y-1">
                                    @foreach ($notifPemasukan as $notif)
                                        <li class="flex items-start">
                                            <span class="inline-block w-2 h-2 mt-1.5 mr-2 bg-blue-400 rounded-full flex-shrink-0"></span>
                                            <div>
                                                <span class="font-medium">{{ $notif['nama_kategori'] }}</span>
                                                <span class="block text-2xs sm:text-xs {{ $notif['text_class'] }}" 
                                                    data-due-date="{{ \Carbon\Carbon::parse($notif['tanggal_berikutnya'])->format('Y-m-d H:i:s') }}"
                                                    data-timezone="{{ config('app.timezone') }}">
                                                    Dijadwalkan: {{ \Carbon\Carbon::parse($notif['tanggal_berikutnya'])->format('Y-m-d') }}
                                                </span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        @if (session()->has('error'))
            <div class="mb-4 p-3 sm:p-4 bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 text-red-700 dark:text-red-300 rounded-lg text-xs sm:text-sm">
                {{ session('error') }}
            </div>
        @endif

        <!-- Two Column Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
            <!-- Pemasukan Column -->
            <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-xs border border-neutral-100 dark:border-neutral-700 overflow-hidden">
                <div class="px-4 sm:px-5 py-2 sm:py-3 bg-green-50 dark:bg-green-900/10 text-green-600 dark:text-green-300 font-medium border-b border-neutral-100 dark:border-neutral-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-4 sm:w-4 text-green-500 dark:text-green-300 inline-block mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                    </svg>
                    Pemasukan
                    <span class="ml-2 text-2xs sm:text-xs font-normal bg-green-100 dark:bg-green-900/20 px-1.5 sm:px-2 py-0.5 rounded-full">
                        {{ $pemasukans->count() }} transaksi
                    </span>
                </div>

                @if($pemasukans->isNotEmpty())
                    <!-- List Header -->
                    <div class="text-xs grid grid-cols-12 gap-1 sm:gap-2 px-2 sm:px-3 py-1 sm:py-2 border-b border-neutral-100 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-700/30 text-2xs text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                        <div class="col-span-6 font-medium">Kategori</div>
                        <div class="col-span-3 font-medium">Jumlah</div>
                        <div class="col-span-3 text-right font-medium">Aksi</div>
                    </div>

                    @foreach ($pemasukans as $income)
                        <div class="grid grid-cols-12 gap-1 sm:gap-2 px-2 sm:px-3 py-1.5 sm:py-2 border-b border-neutral-100 dark:border-neutral-700 hover:bg-neutral-50 dark:hover:bg-neutral-700/20 text-xs">
                            <div class="col-span-6">
                                <div class="font-medium text-neutral-800 dark:text-white truncate text-sm">
                                    {{ $income->category->name ?? '-' }}
                                </div>
                                <div class="flex items-center mt-0.5 text-2xs text-neutral-500 dark:text-neutral-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-2.5 w-2.5 mr-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span>{{ $income->tanggal_berikutnya->translatedFormat('d M') }}</span>
                                    <span class="px-0.5 sm:px-1 py-0.5 ml-1 rounded-full text-2xs bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-200">
                                        {{ substr(ucfirst($income->frekuensi), 0, 3) }}
                                    </span>
                                    @if($income->tanggal_berikutnya->isPast())
                                        <span class="ml-1 text-2xs px-0.5 sm:px-1 py-0.5 bg-neutral-100 dark:bg-neutral-700 text-neutral-800 dark:text-neutral-200 rounded-full">Lewat</span>
                                    @elseif($income->tanggal_berikutnya->isToday())
                                        <span class="ml-1 text-2xs px-0.5 sm:px-1 py-0.5 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-200 rounded-full">Hari ini</span>
                                    @elseif($income->tanggal_berikutnya->diffInDays(now()) <= 3)
                                        <span class="ml-1 text-2xs px-0.5 sm:px-1 py-0.5 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-200 rounded-full">Segera</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-span-3 font-semibold text-green-600 dark:text-green-300 flex items-center text-sm">
                                Rp{{ number_format($income->jumlah, 0, ',', '.') }}
                            </div>
                            <div class="col-span-3 flex justify-end gap-0.5">
                                @if($this->bolehTransaksi($income))
                                    <button wire:click="lakukanTransaksi({{ $income->id }})" class="p-0.5 sm:p-1 text-indigo-600 dark:text-indigo-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 rounded" title="Catat transaksi">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 sm:h-4 sm:w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </button>
                                @endif
                                <a href="{{ route('transaksi', ['edit_tetap' => $income->id]) }}" class="p-0.5 sm:p-1 text-neutral-600 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-700 rounded flex justify-center items-center" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 sm:h-4 sm:w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <button wire:click="hapus({{ $income->id }})" onclick="return confirm('Hapus transaksi ini?') || event.stopImmediatePropagation()" class="p-0.5 sm:p-1 text-red-600 dark:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/30 rounded" title="Hapus">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 sm:h-4 sm:w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="p-4 sm:p-6 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-8 sm:h-12 w-8 sm:w-12 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-2 sm:mt-3 text-sm font-medium text-neutral-900 dark:text-white">Belum ada pemasukan tetap</h3>
                        <p class="mt-1 text-2xs sm:text-xs text-neutral-500 dark:text-neutral-400">Tambahkan pemasukan rutin seperti gaji atau pendapatan lainnya</p>
                    </div>
                @endif
            </div>

            <!-- Pengeluaran Column -->
            <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-xs border border-neutral-100 dark:border-neutral-700 overflow-hidden">
                <div class="px-4 sm:px-5 py-2 sm:py-3 bg-red-50 dark:bg-red-900/10 text-red-600 dark:text-red-300 font-medium border-b border-neutral-100 dark:border-neutral-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-4 sm:w-4 inline-block mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" />
                    </svg>
                    Pengeluaran
                    <span class="ml-2 text-2xs sm:text-xs font-normal bg-red-100 dark:bg-red-900/20 px-1.5 sm:px-2 py-0.5 rounded-full">
                        {{ $pengeluarans->count() }} transaksi
                    </span>
                </div>
                @if($pengeluarans->isNotEmpty())
                    <!-- List Header -->
                    <div class="text-xs grid grid-cols-12 gap-1 sm:gap-2 px-2 sm:px-3 py-1 sm:py-2 border-b border-neutral-100 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-700/30 text-2xs text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                        <div class="col-span-6 font-medium">Kategori</div>
                        <div class="col-span-3 font-medium">Jumlah</div>
                        <div class="col-span-3 text-right font-medium">Aksi</div>
                    </div>

                    @foreach ($pengeluarans as $expense)
                        <div class="grid grid-cols-12 gap-1 sm:gap-2 px-2 sm:px-3 py-1.5 sm:py-2 border-b border-neutral-100 dark:border-neutral-700 hover:bg-neutral-50 dark:hover:bg-neutral-700/20 text-xs">
                            <div class="col-span-6">
                                <div class="font-medium text-neutral-800 dark:text-white truncate text-sm">
                                    {{ $expense->category->name ?? '-' }}
                                </div>
                                <div class="flex items-center mt-0.5 text-2xs text-neutral-500 dark:text-neutral-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-2.5 w-2.5 mr-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span>{{ $expense->tanggal_berikutnya->translatedFormat('d M') }}</span>
                                    <span class="px-0.5 sm:px-1 py-0.5 ml-1 rounded-full text-2xs bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-200">
                                        {{ substr(ucfirst($expense->frekuensi), 0, 3) }}
                                    </span>
                                    @if($expense->tanggal_berikutnya->isPast())
                                        <span class="ml-1 text-2xs px-0.5 sm:px-1 py-0.5 bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-200 rounded-full">Lewat</span>
                                    @elseif($expense->tanggal_berikutnya->isToday())
                                        <span class="ml-1 text-2xs px-0.5 sm:px-1 py-0.5 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-200 rounded-full">Hari ini</span>
                                    @elseif($expense->tanggal_berikutnya->diffInDays(now()) <= 3)
                                        <span class="ml-1 text-2xs px-0.5 sm:px-1 py-0.5 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-200 rounded-full">Segera</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-span-3 font-semibold text-red-600 dark:text-red-300 flex items-center text-sm">
                                Rp{{ number_format($expense->jumlah, 0, ',', '.') }}
                            </div>
                            <div class="col-span-3 flex justify-end gap-0.5">
                                @if($this->bolehTransaksi($expense))
                                    <button wire:click="lakukanTransaksi({{ $expense->id }})" class="p-0.5 sm:p-1 text-indigo-600 dark:text-indigo-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 rounded" title="Bayar sekarang">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 sm:h-4 sm:w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </button>
                                @endif
                                <a href="{{ route('transaksi', ['edit_tetap' => $expense->id]) }}" class="p-0.5 sm:p-1 text-neutral-600 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-700 rounded flex justify-center items-center" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 sm:h-4 sm:w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <button wire:click="hapus({{ $expense->id }})" onclick="return confirm('Hapus transaksi ini?') || event.stopImmediatePropagation()" class="p-0.5 sm:p-1 text-red-600 dark:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/30 rounded" title="Hapus">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 sm:h-4 sm:w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="p-4 sm:p-6 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-8 sm:h-12 w-8 sm:w-12 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-2 sm:mt-3 text-sm font-medium text-neutral-900 dark:text-white">Belum ada pengeluaran tetap</h3>
                        <p class="mt-1 text-2xs sm:text-xs text-neutral-500 dark:text-neutral-400">Tambahkan pengeluaran rutin seperti tagihan atau cicilan</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        // Gunakan namespace untuk menghindari konflik
        window.NotificationCounter = {
            interval: null,
            observer: null,

            init: function () {
                this.cleanup(); // Bersihkan dulu sebelum inisialisasi baru
                this.updateTimeCounters();
                this.setupInterval();
                this.setupLivewireHooks();
            },

            cleanup: function () {
                if (this.interval) clearInterval(this.interval);
                if (this.observer) this.observer.disconnect();
            },

            formatDuration: function (hours) {
                const fullHours = Math.floor(hours);
                const minutes = Math.round((hours - fullHours) * 60);

                if (fullHours > 0 && minutes > 0) {
                    return `${fullHours} jam ${minutes} menit`;
                } else if (fullHours > 0) {
                    return `${fullHours} jam`;
                } else if (minutes > 0) {
                    return `${minutes} menit`;
                }
                return 'beberapa saat';
            },

            updateTimeCounters: function () {
                const now = new Date();
                const elements = document.querySelectorAll('[data-due-date]');

                elements.forEach(element => {
                    try {
                        const dueDate = new Date(element.getAttribute('data-due-date'));
                        const baseText = element.dataset.baseText || element.textContent.split('•')[0].trim();
                        element.dataset.baseText = baseText; // Simpan untuk penggunaan berikutnya

                        const diffMs = dueDate - now;
                        const diffHours = diffMs / (1000 * 60 * 60);

                        let timeText = '';
                        if (diffHours > 0 && diffHours <= 24) {
                            timeText = ' • ' + this.formatDuration(diffHours) + ' lagi';
                        } else if (diffHours > 24) {
                            const days = Math.floor(diffHours / 24);
                            const remainingHours = Math.round(diffHours % 24);
                            timeText = ' • ' + days + ' hari' + ' lagi';
                        } else if (diffHours <= 0 && diffHours > -24) {
                            timeText = ' • ' + this.formatDuration(Math.abs(diffHours)) + ' lalu';
                        } else if (diffHours <= -24) {
                            const days = Math.floor(Math.abs(diffHours) / 24);
                            timeText = ' • ' + days + ' hari lalu';
                        }

                        element.textContent = baseText + timeText;
                    } catch (e) {
                        console.error("Error updating counter:", e);
                    }
                });
            },

            setupInterval: function () {
                this.interval = setInterval(() => {
                    this.updateTimeCounters();
                    this.checkDayChange();
                }, 60000); // Update setiap 1 menit
            },

            checkDayChange: function () {
                const today = new Date().toDateString();
                if (window.lastCheckedDate && window.lastCheckedDate !== today) {
                    Livewire.dispatch('refreshNotifications');
                }
                window.lastCheckedDate = today;
            },

            setupLivewireHooks: function () {
                // Handle Livewire page navigation
                document.addEventListener('livewire:navigated', () => {
                    this.init();
                });

                // Handle Turbolinks (jika digunakan)
                document.addEventListener('turbolinks:load', () => {
                    this.init();
                });
            }
        };

        // Inisialisasi saat pertama load
        document.addEventListener('DOMContentLoaded', function () {
            NotificationCounter.init();
        });

        // Untuk komponen Livewire yang di-render ulang tanpa navigasi
        document.addEventListener('livewire:update', function () {
            NotificationCounter.updateTimeCounters();
        });
    </script>
@endpush
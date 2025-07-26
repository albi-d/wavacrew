<div
    class="bg-white dark:bg-neutral-800 rounded-lg shadow-md dark:shadow-neutral-700/50 p-6 transition-colors duration-300">
    <!-- Chart Section -->
    <div class="mb-8">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-100">Grafik Keuangan</h2>
        <div class="bg-gray-50 dark:bg-neutral-700/50 p-4 rounded-lg">
            <canvas id="keuanganChart" class="w-full h-80" wire:ignore></canvas>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="flex flex-col md:flex-row gap-6 mb-8">
        <div class="w-full md:w-1/3">
            <label for="tahun" class="block text-sm font-medium text-gray-700 dark:text-neutral-300 mb-1">Tahun</label>
            <select wire:model.live="tahun" id="tahun"
                class="w-full px-4 py-2 border border-gray-300 dark:border-neutral-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-neutral-700 text-neutral-900 dark:text-neutral-100">
                @for ($i = now()->year; $i >= now()->year - 10; $i--)
                    <option value="{{ $i }}" {{ $i == $tahun ? 'selected' : '' }} class="dark:bg-neutral-700">{{ $i }}
                    </option>
                @endfor
            </select>
        </div>

        <div class="w-full md:w-1/3">
            <label for="bulan" class="block text-sm font-medium text-gray-700 dark:text-neutral-300 mb-1">Bulan</label>
            <select wire:model.live="bulan" id="bulan"
                class="w-full px-4 py-2 border border-gray-300 dark:border-neutral-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-neutral-700 text-neutral-900 dark:text-neutral-100">
                <option value="" class="dark:bg-neutral-700">Semua Bulan</option>
                @for ($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ $i == $bulan ? 'selected' : '' }} class="dark:bg-neutral-700">
                        {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                    </option>
                @endfor
            </select>
        </div>
    </div>

    <!-- Top Categories Section -->
    <div>
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-100">Pengeluaran Terbanyak</h2>
            <a href="{{ route('laporan.export.pdf', ['tahun' => $tahun, 'bulan' => $bulan ?: null]) }}" target="_blank"
                class="flex items-center px-3 py-1.5 bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300 rounded-md text-sm hover:bg-indigo-200 dark:hover:bg-indigo-800 transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Export PDF
            </a>
        </div>
        <div class="bg-gray-50 dark:bg-neutral-700 p-4 rounded-lg">
            <ul class="space-y-3">
                @foreach ($topKategori as $item)
                    <li
                        class="flex justify-between items-center p-3 bg-white dark:bg-neutral-600 rounded-md shadow-sm hover:shadow-md dark:hover:shadow-neutral-500/30 transition-all duration-200">
                        <span class="font-medium text-gray-700 dark:text-neutral-100">{{ $item['category_name'] }}</span>
                        <span
                            class="font-semibold text-red-600 dark:text-red-400">Rp{{ number_format($item['total'], 0, ',', '.') }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>


    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const isDark = document.documentElement.classList.contains('dark');

                // Warna yang lebih natural untuk dark mode
                const chartColors = {
                    light: {
                        pemasukan: {
                            bg: 'rgba(59, 130, 246, 0.5)',
                            border: 'rgba(59, 130, 246, 1)'
                        },
                        pengeluaran: {
                            bg: 'rgba(239, 68, 68, 0.5)',
                            border: 'rgba(239, 68, 68, 1)'
                        },
                        text: '#6B7280',
                        grid: 'rgba(0, 0, 0, 0.1)',
                        background: '#fff'
                    },
                    dark: {
                        pemasukan: {
                            bg: 'rgba(100, 149, 237, 0.6)',
                            border: 'rgba(70, 130, 180, 1)'
                        },
                        pengeluaran: {
                            bg: 'rgba(255, 107, 107, 0.6)',
                            border: 'rgba(220, 60, 60, 1)'
                        },
                        text: '#E5E7EB',
                        grid: 'rgba(255, 255, 255, 0.1)',
                        background: 'rgba(31, 41, 55, 0.5)'
                    }
                };

                const currentColors = isDark ? chartColors.dark : chartColors.light;

                // Apply global chart config
                Chart.defaults.color = currentColors.text;
                Chart.defaults.borderColor = currentColors.grid;

                function initChart() {
                    const ctx = document.getElementById('keuanganChart');
                    if (!ctx) return;

                    if (window.keuanganChart instanceof Chart) {
                        window.keuanganChart.destroy();
                    }

                    const rawData = @json($dataBulanan);
                    const months = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
                    const pemasukan = months.map(bulan => rawData[bulan]?.find(item => item.jenis === 'Pemasukan')?.total || 0);
                    const pengeluaran = months.map(bulan => rawData[bulan]?.find(item => item.jenis === 'Pengeluaran')?.total || 0);

                    window.keuanganChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                            datasets: [
                                {
                                    label: 'Pemasukan',
                                    data: pemasukan,
                                    backgroundColor: currentColors.pemasukan.bg,
                                    borderColor: currentColors.pemasukan.border,
                                    borderWidth: 1,
                                    borderRadius: 4
                                },
                                {
                                    label: 'Pengeluaran',
                                    data: pengeluaran,
                                    backgroundColor: currentColors.pengeluaran.bg,
                                    borderColor: currentColors.pengeluaran.border,
                                    borderWidth: 1,
                                    borderRadius: 4
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: { color: currentColors.grid },
                                    ticks: {
                                        callback: function (value) {
                                            return 'Rp' + value.toLocaleString('id-ID');
                                        }
                                    }
                                },
                                x: {
                                    grid: { display: false }
                                }
                            },
                            plugins: {
                                legend: {
                                    position: 'top',
                                    labels: { boxWidth: 12, padding: 20 }
                                },
                                tooltip: {
                                    backgroundColor: isDark ? '#1F2937' : '#FFFFFF',
                                    titleColor: isDark ? '#E5E7EB' : '#111827',
                                    bodyColor: isDark ? '#E5E7EB' : '#111827',
                                    borderColor: isDark ? '#4B5563' : '#E5E7EB',
                                    callbacks: {
                                        label: function (context) {
                                            return context.dataset.label + ': Rp' + context.raw.toLocaleString('id-ID');
                                        }
                                    }
                                }
                            }
                        }
                    });
                }

                // Init first time
                initChart();

                // Livewire hook
                Livewire.hook('message.processed', (el, component) => {
                    setTimeout(() => {
                        initChart();
                    }, 100);
                });

                // Dark mode observer
                new MutationObserver((mutations) => {
                    mutations.forEach(() => {
                        if (window.keuanganChart) {
                            window.keuanganChart.destroy();
                            initChart();
                        }
                    });
                }).observe(document.documentElement, {
                    attributes: true,
                    attributeFilter: ['class']
                });
            });
        </script>
    @endpush
</div>
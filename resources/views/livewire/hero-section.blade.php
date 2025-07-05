<x-layouts.app :title="__('Manajemen Transaksi')">
    <div
        class="relative overflow-hidden bg-gradient-to-br from-indigo-600 to-blue-500 text-white py-32 px-6 text-center">
        <!-- Background animation shapes -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-32 -left-20 w-72 h-72 bg-white opacity-10 rounded-full animate-pulse delay-1000">
            </div>
            <div class="absolute top-20 right-0 w-96 h-96 bg-white opacity-10 rounded-full animate-spin-slow"></div>
        </div>

        <div class="relative z-10 max-w-4xl mx-auto">
            <h1 class="text-5xl font-extrabold leading-tight animate__animated animate__fadeInDown">Kelola Keuanganmu
                Tanpa
                Stres</h1>
            <p class="mt-6 text-lg animate__animated animate__fadeInUp animate__delay-1s">
                Aplikasi manajemen keuangan pribadi untuk membantu kamu mencatat, mengatur, dan mencapai tujuan
                finansial.
            </p>

            <div class="mt-10 flex justify-center gap-4 animate__animated animate__fadeInUp animate__delay-2s">
                <a href="{{ route('register') }}"
                    class="bg-white text-blue-600 font-semibold px-6 py-3 rounded-lg shadow-lg hover:bg-gray-100 transition transform hover:scale-105 duration-300">
                    Daftar Sekarang
                </a>
                <a href="{{ route('login') }}"
                    class="border border-white px-6 py-3 rounded-lg hover:bg-white hover:text-blue-600 transition transform hover:scale-105 duration-300">
                    Sudah Punya Akun?
                </a>
            </div>
        </div>
    </div>

    <style>
        @keyframes spin-slow {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .animate-spin-slow {
            animation: spin-slow 18s linear infinite;
        }
    </style>
</x-layouts.app>
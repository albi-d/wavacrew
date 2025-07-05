<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @php use Illuminate\Support\Facades\Route; @endphp
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Meow Money | Manajemen Keuangan Modern</title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Animasi Background */
        .animated-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .bg-element {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.15;
            animation: float 15s infinite linear;
        }

        .bg-1 {
            width: 150px;
            height: 150px;
            background: #4f46e5;
            top: 10%;
            left: 5%;
            animation-delay: 0s;
        }

        .bg-2 {
            width: 200px;
            height: 200px;
            background: #7c3aed;
            bottom: 15%;
            right: 10%;
            animation-delay: 3s;
        }

        .bg-3 {
            width: 125px;
            height: 125px;
            background: #10b981;
            top: 60%;
            left: 20%;
            animation-delay: 6s;
        }

        .bg-4 {
            width: 175px;
            height: 175px;
            background: #3b82f6;
            top: 30%;
            right: 20%;
            animation-delay: 9s;
        }

        @keyframes float {
            0% {
                transform: translate(0, 0) rotate(0deg);
            }

            50% {
                transform: translate(50px, 50px) rotate(180deg);
            }

            100% {
                transform: translate(0, 0) rotate(360deg);
            }
        }

        .logo-float {
            animation: subtleFloat 4s ease-in-out infinite;
        }

        @keyframes subtleFloat {

            0%,
            100% {
                transform: translateY(0) rotate(0deg);
            }

            50% {
                transform: translateY(-8px) rotate(2deg);
            }
        }

        /* Dark mode adjustment */
        .dark .bg-element {
            opacity: 0.08;
        }

        /* Animasi Logo */
        .logo-animate {
            transition: all 0.5s ease-in-out;
            transform-origin: center;
        }

        .logo-animate:hover {
            animation: gentlePulse 2s ease-in-out infinite;
            transform: scale(1.05);
        }

        @keyframes gentlePulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.9;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Tombol Utama */
        .btn-primary {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            box-shadow: 0 4px 6px rgba(79, 70, 229, 0.1);
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #4338ca 0%, #6d28d9 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(79, 70, 229, 0.2);
        }

        /* Efek hover card */
        .feature-card {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 1px solid rgba(0, 0, 0, 0.05);
            background-color: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
        }

        .dark .feature-card {
            border: 1px solid rgba(255, 255, 255, 0.05);
            background-color: rgba(31, 41, 55, 0.7);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        /* Section styling with glass effect */
        .glass-section {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
        }

        .dark .glass-section {
            background: rgba(17, 24, 39, 0.8);
        }

        /* Parallax effect for hero */
        .hero-parallax {
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        @media (min-width: 640px) {
            .bg-1 {
                width: 200px;
                height: 200px;
            }

            .bg-2 {
                width: 250px;
                height: 250px;
            }

            .bg-3 {
                width: 175px;
                height: 175px;
            }

            .bg-4 {
                width: 225px;
                height: 225px;
            }
        }

        @media (min-width: 1024px) {
            .bg-1 {
                width: 300px;
                height: 300px;
            }

            .bg-2 {
                width: 400px;
                height: 400px;
            }

            .bg-3 {
                width: 250px;
                height: 250px;
            }

            .bg-4 {
                width: 350px;
                height: 350px;
            }
        }
    </style>
</head>

<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC] min-h-screen">
    <!-- Animated Background Elements -->
    <div class="animated-bg">
        <div class="bg-element bg-1"></div>
        <div class="bg-element bg-2"></div>
        <div class="bg-element bg-3"></div>
        <div class="bg-element bg-4"></div>
    </div>

    <header class="w-full py-4 sm:py-6 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto" data-aos="fade-down">
        <div class="flex flex-col sm:flex-row items-center justify-between">
            <div class="flex items-center mb-4 sm:mb-0">
                <div class="w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center logo-animate">
                    <x-app-logo-icon class="size-full fill-current text-white dark:text-black" />
                </div>
                <span class="ml-2 text-lg sm:text-xl font-bold dark:text-white">Meow Money</span>
            </div>
            <nav class="flex items-center space-x-2 sm:space-x-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="relative px-4 py-1.5 sm:px-6 sm:py-2.5 text-xs sm:text-sm font-medium rounded-lg bg-indigo-600 text-white 
                                                                           hover:bg-indigo-700 transition-all duration-300 shadow-md hover:shadow-lg
                                                                           overflow-hidden group">
                            <span class="relative z-10 flex items-center">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                Dashboard
                            </span>
                            <span
                                class="absolute inset-0 bg-gradient-to-r from-indigo-700 to-purple-700 
                                                                                opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="relative px-4 py-1.5 sm:px-6 sm:py-2.5 text-xs sm:text-sm font-medium rounded-lg border-2 border-indigo-600 
                                                                           text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-gray-800/50
                                                                           transition-all duration-300 group overflow-hidden">
                            <span class="relative z-10 flex items-center">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                Masuk
                            </span>
                            <span class="absolute inset-0 bg-indigo-600/10 group-hover:bg-indigo-600/20 
                                                                                transition-all duration-500"></span>
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="relative px-4 py-1.5 sm:px-6 sm:py-2.5 text-xs sm:text-sm font-medium rounded-lg bg-gradient-to-r 
                                                                                                           from-indigo-600 to-purple-600 text-white hover:from-indigo-700 hover:to-purple-700 
                                                                                                           transition-all duration-500 shadow-lg hover:shadow-xl overflow-hidden group">
                                <span class="relative z-10 flex items-center">
                                    <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                        </path>
                                    </svg>
                                    Daftar
                                </span>
                                <span
                                    class="absolute inset-0 bg-gradient-to-r from-indigo-500 to-purple-500 
                                                                                                              opacity-0 group-hover:opacity-100 transition-opacity duration-500"></span>
                                <span
                                    class="absolute top-0 left-0 w-full h-0.5 bg-white/30 
                                                                                                              group-hover:h-full group-hover:opacity-0 transition-all duration-700"></span>
                            </a>
                        @endif
                    @endauth
                @endif
            </nav>
        </div>
    </header>

    <main>
        <!-- Hero Section -->
        <section class="py-12 sm:py-16 lg:py-20 px-4 sm:px-6 lg:px-8 hero-parallax glass-section"
            style="background-image: linear-gradient(rgba(245, 247, 250, 0.9), rgba(228, 232, 237, 0.9)), url('https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?q=80&w=1470&auto=format&fit=crop')">
            <div class="max-w-7xl mx-auto">
                <div class="text-center">
                    <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold tracking-tight text-gray-900 dark:text-white mb-4 sm:mb-6"
                        data-aos="fade-up">
                        Kendalikan <span class="text-indigo-600 dark:text-indigo-400">Keuangan Anda</span> dengan Mudah
                    </h1>
                    <p class="text-base sm:text-lg md:text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto mb-8 sm:mb-10"
                        data-aos="fade-up" data-aos-delay="100">
                        Alat manajemen keuangan yang powerful namun sederhana untuk membantu Anda melacak pengeluaran,
                        mengelola anggaran, dan mencapai tujuan finansial.
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center gap-3 sm:gap-4" data-aos="fade-up"
                        data-aos-delay="200">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="relative px-6 py-2.5 sm:px-8 sm:py-3.5 text-sm sm:text-base font-medium rounded-lg bg-gradient-to-r from-indigo-600 to-purple-600 
                                                       text-white hover:from-indigo-700 hover:to-purple-700 transition-all duration-500 
                                                       shadow-lg hover:shadow-xl group overflow-hidden">
                                <span class="relative z-10 flex items-center justify-center">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1 sm:mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                                        </path>
                                    </svg>
                                    Buka Dashboard
                                </span>
                                <span
                                    class="absolute inset-0 bg-gradient-to-r from-indigo-500 to-purple-500 
                                                              opacity-0 group-hover:opacity-100 transition-opacity duration-500"></span>
                                <span
                                    class="absolute top-0 left-0 w-full h-0.5 bg-white/30 
                                                              group-hover:h-full group-hover:opacity-0 transition-all duration-700"></span>
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="relative px-6 py-2.5 sm:px-8 sm:py-3.5 text-sm sm:text-base font-medium rounded-lg bg-gradient-to-r from-indigo-600 to-purple-600 
                                                       text-white hover:from-indigo-700 hover:to-purple-700 transition-all duration-500 
                                                       shadow-lg hover:shadow-xl group overflow-hidden">
                                <span class="relative z-10 flex items-center justify-center">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1 sm:mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    Mulai Sekarang
                                </span>
                                <span
                                    class="absolute inset-0 bg-gradient-to-r from-indigo-500 to-purple-500 
                                                              opacity-0 group-hover:opacity-100 transition-opacity duration-500"></span>
                                <span
                                    class="absolute top-0 left-0 w-full h-0.5 bg-white/30 
                                                              group-hover:h-full group-hover:opacity-0 transition-all duration-700"></span>
                            </a>

                            <a href="{{ route('login') }}" class="relative px-6 py-2.5 sm:px-8 sm:py-3.5 text-sm sm:text-base font-medium rounded-lg border-2 border-indigo-600 
                                                       text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50/80 dark:hover:bg-gray-800/50
                                                       transition-all duration-500 group overflow-hidden">
                                <span class="relative z-10 flex items-center justify-center">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1 sm:mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                    Masuk Akun
                                </span>
                                <span
                                    class="absolute inset-0 bg-indigo-600/5 group-hover:bg-indigo-600/10 
                                                              dark:group-hover:bg-indigo-400/10 transition-all duration-500"></span>
                                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-indigo-600 
                                                              group-hover:w-full transition-all duration-500"></span>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-12 sm:py-16 lg:py-20 px-4 sm:px-6 lg:px-8 glass-section">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-12 sm:mb-16" data-aos="fade-up">
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-3 sm:mb-4">Semua yang
                        Anda Butuhkan untuk
                        Mengelola Uang</h2>
                    <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto text-sm sm:text-base">Alat komprehensif
                        kami membantu Anda
                        mengontrol keuangan dengan mudah.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                    <!-- Feature 1 -->
                    <div class="feature-card p-6 sm:p-8 rounded-lg" data-aos="fade-up" data-aos-delay="100">
                        <div
                            class="w-10 h-10 sm:w-12 sm:h-12 bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center mb-4 sm:mb-6">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-indigo-600 dark:text-indigo-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-white mb-2 sm:mb-3">
                            Pelacakan Pengeluaran</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm sm:text-base">Catat dan kategorikan
                            pengeluaran Anda dengan mudah
                            untuk memahami kemana uang Anda mengalir.</p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="feature-card p-6 sm:p-8 rounded-lg" data-aos="fade-up" data-aos-delay="200">
                        <div
                            class="w-10 h-10 sm:w-12 sm:h-12 bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center mb-4 sm:mb-6">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-indigo-600 dark:text-indigo-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-white mb-2 sm:mb-3">
                            Perencanaan Anggaran</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm sm:text-base">Tetapkan anggaran bulanan dan
                            dapatkan notifikasi
                            ketika Anda mendekati batas yang ditentukan.</p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="feature-card p-6 sm:p-8 rounded-lg" data-aos="fade-up" data-aos-delay="300">
                        <div
                            class="w-10 h-10 sm:w-12 sm:h-12 bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center mb-4 sm:mb-6">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-indigo-600 dark:text-indigo-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-white mb-2 sm:mb-3">Laporan
                            Keuangan</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm sm:text-base">Buat laporan detail untuk
                            memvisualisasikan
                            kesehatan keuangan Anda dari waktu ke waktu.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-12 sm:py-16 lg:py-20 px-4 sm:px-6 lg:px-8 bg-indigo-50 dark:bg-indigo-900/20 glass-section">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-4 sm:mb-6"
                    data-aos="fade-up">Siap Mengubah Hidup
                    Finansial Anda?</h2>
                <p class="text-sm sm:text-base text-gray-600 dark:text-gray-300 mb-6 sm:mb-8" data-aos="fade-up"
                    data-aos-delay="100">
                    Bergabunglah dengan ribuan pengguna yang telah mengendalikan keuangan mereka dengan alat kami.</p>
                <div class="flex flex-col sm:flex-row justify-center gap-3 sm:gap-4" data-aos="fade-up"
                    data-aos-delay="200">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="relative px-6 py-2.5 sm:px-8 sm:py-3.5 text-sm sm:text-base font-medium rounded-lg bg-gradient-to-r from-indigo-600 to-purple-600 
                                                       text-white hover:from-indigo-700 hover:to-purple-700 transition-all duration-500 
                                                       shadow-lg hover:shadow-xl group overflow-hidden">
                            <span class="relative z-10 flex items-center justify-center">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1 sm:mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                                    </path>
                                </svg>
                                Buka Dashboard
                            </span>
                            <span
                                class="absolute inset-0 bg-gradient-to-r from-indigo-500 to-purple-500 
                                                              opacity-0 group-hover:opacity-100 transition-opacity duration-500"></span>
                            <span
                                class="absolute top-0 left-0 w-full h-0.5 bg-white/30 
                                                              group-hover:h-full group-hover:opacity-0 transition-all duration-700"></span>
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="relative px-6 py-2.5 sm:px-8 sm:py-3.5 text-sm sm:text-base font-medium rounded-lg bg-gradient-to-r from-indigo-600 to-purple-600 
                                                       text-white hover:from-indigo-700 hover:to-purple-700 transition-all duration-500 
                                                       shadow-lg hover:shadow-xl group overflow-hidden">
                            <span class="relative z-10 flex items-center justify-center">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1 sm:mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                Mulai Gratis
                            </span>
                            <span
                                class="absolute inset-0 bg-gradient-to-r from-indigo-500 to-purple-500 
                                                              opacity-0 group-hover:opacity-100 transition-opacity duration-500"></span>
                            <span
                                class="absolute top-0 left-0 w-full h-0.5 bg-white/30 
                                                              group-hover:h-full group-hover:opacity-0 transition-all duration-700"></span>
                        </a>
                    @endauth
                </div>
            </div>
        </section>
    </main>

    <footer class="py-8 sm:py-12 px-4 sm:px-6 lg:px-8 bg-gray-50 dark:bg-gray-900/50 glass-section" data-aos="fade-up">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row justify-center items-center">
                <div class="flex items-center mb-4 sm:mb-6 md:mb-0">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center logo-animate">
                        <x-app-logo-icon class="size-full fill-current text-white dark:text-black" />
                    </div>
                    <span class="ml-2 text-lg sm:text-xl font-bold dark:text-white">Meow Money</span>
                </div>
            </div>
            <div
                class="mt-6 sm:mt-8 pt-6 sm:pt-8 border-t border-gray-200 dark:border-gray-800 text-center text-gray-500 dark:text-gray-400 text-sm sm:text-base">
                <p>© 2025 Meow Money. Seluruh hak cipta dilindungi.</p>
            </div>
        </div>
    </footer>

    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Inisialisasi AOS
        document.addEventListener('DOMContentLoaded', function () {
            AOS.init({
                duration: 600,
                easing: 'ease-out-quad',
                once: false,
                offset: 100,
                delay: 100,
            });

            // Parallax effect for background elements
            document.addEventListener('scroll', function () {
                const scrollPosition = window.pageYOffset;
                const bgElements = document.querySelectorAll('.bg-element');

                bgElements.forEach((element, index) => {
                    const speed = 0.2 + (index * 0.1);
                    const yPos = -(scrollPosition * speed);
                    element.style.transform = `translateY(${yPos}px)`;
                });
            });
        });
    </script>
</body>

</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'LUNGSURIN') }} - Marketplace Barang Bekas Mahasiswa</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

        <style>
            .gradient-text {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }
            .gradient-bg {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }
            .gradient-bg-light {
                background: linear-gradient(135deg, rgba(102,126,234,0.1) 0%, rgba(118,75,162,0.1) 100%);
            }
            .floating {
                animation: floating 3s ease-in-out infinite;
            }
            .floating-delay {
                animation: floating 3s ease-in-out infinite;
                animation-delay: 1s;
            }
            .floating-delay-2 {
                animation: floating 3s ease-in-out infinite;
                animation-delay: 2s;
            }
            @keyframes floating {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-15px); }
            }
            .slide-up {
                animation: slideUp 0.8s ease-out forwards;
            }
            .slide-up-delay {
                animation: slideUp 0.8s ease-out forwards;
                animation-delay: 0.2s;
                opacity: 0;
            }
            .slide-up-delay-2 {
                animation: slideUp 0.8s ease-out forwards;
                animation-delay: 0.4s;
                opacity: 0;
            }
            @keyframes slideUp {
                from {
                    opacity: 0;
                    transform: translateY(40px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            .card-hover {
                transition: all 0.3s ease;
            }
            .card-hover:hover {
                transform: translateY(-8px);
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            }
            .blob {
                border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
                animation: blob 8s ease-in-out infinite;
            }
            @keyframes blob {
                0%, 100% { border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; }
                25% { border-radius: 58% 42% 75% 25% / 76% 46% 54% 24%; }
                50% { border-radius: 50% 50% 33% 67% / 55% 27% 73% 45%; }
                75% { border-radius: 33% 67% 58% 42% / 63% 68% 32% 37%; }
            }
        </style>
    </head>
    <body class="bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100 antialiased overflow-x-hidden">
        
        <!-- Navbar -->
        <nav class="fixed top-0 left-0 right-0 z-50 bg-white/80 dark:bg-gray-900/80 backdrop-blur-lg border-b border-gray-100 dark:border-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <!-- Logo -->
                    <a href="/" class="flex items-center gap-2 group">
                        <div class="w-10 h-10 gradient-bg rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                        <span class="text-xl font-bold gradient-text">{{ config('app.name', 'LUNGSURIN') }}</span>
                    </a>

                    <!-- Nav Links -->
                    <div class="flex items-center gap-2 sm:gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                                Masuk
                            </a>
                            <a href="{{ route('register') }}" class="px-5 py-2.5 text-sm font-semibold text-white gradient-bg rounded-xl shadow-lg shadow-indigo-500/30 hover:shadow-xl hover:shadow-indigo-500/40 transition-all transform hover:-translate-y-0.5">
                                Daftar
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="relative min-h-screen flex items-center pt-16 overflow-hidden">
            <!-- Background Blobs -->
            <div class="absolute top-20 -left-20 w-96 h-96 bg-indigo-300/30 dark:bg-indigo-500/20 rounded-full blur-3xl blob"></div>
            <div class="absolute bottom-20 -right-20 w-96 h-96 bg-purple-300/30 dark:bg-purple-500/20 rounded-full blur-3xl blob" style="animation-delay: -4s;"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-gradient-to-r from-indigo-100/50 to-purple-100/50 dark:from-indigo-900/20 dark:to-purple-900/20 rounded-full blur-3xl"></div>

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <!-- Left Content -->
                    <div class="text-center lg:text-left">
                        <div class="slide-up">
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-indigo-100 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300 mb-6">
                                <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                                Platform Aktif untuk Mahasiswa
                            </span>
                        </div>
                        
                        <h1 class="slide-up-delay text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight mb-6">
                            Jual Beli Barang Bekas
                            <span class="gradient-text block">Sesama Mahasiswa</span>
                        </h1>
                        
                        <p class="slide-up-delay-2 text-lg sm:text-xl text-gray-600 dark:text-gray-400 mb-8 max-w-xl mx-auto lg:mx-0">
                            Marketplace khusus mahasiswa untuk lungsuran buku, elektronik, perabotan kos, dan lainnya. COD langsung di kampus!
                        </p>

                        <div class="slide-up-delay-2 flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center px-8 py-4 text-base font-semibold text-white gradient-bg rounded-xl shadow-lg shadow-indigo-500/30 hover:shadow-xl hover:shadow-indigo-500/40 transition-all transform hover:-translate-y-1">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                    Ke Dashboard
                                </a>
                            @else
                                <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-8 py-4 text-base font-semibold text-white gradient-bg rounded-xl shadow-lg shadow-indigo-500/30 hover:shadow-xl hover:shadow-indigo-500/40 transition-all transform hover:-translate-y-1">
                                    Mulai Jual Barang
                                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                </a>
                                <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-8 py-4 text-base font-semibold text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-xl hover:border-indigo-300 dark:hover:border-indigo-600 transition-all transform hover:-translate-y-1">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                    </svg>
                                    Masuk Akun
                                </a>
                            @endauth
                        </div>

                        <!-- Stats -->
                        <div class="slide-up-delay-2 grid grid-cols-3 gap-6 mt-12 pt-8 border-t border-gray-200 dark:border-gray-800">
                            <div class="text-center lg:text-left">
                                <div class="text-2xl sm:text-3xl font-bold gradient-text">500+</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Barang Terjual</div>
                            </div>
                            <div class="text-center lg:text-left">
                                <div class="text-2xl sm:text-3xl font-bold gradient-text">1K+</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Pengguna</div>
                            </div>
                            <div class="text-center lg:text-left">
                                <div class="text-2xl sm:text-3xl font-bold gradient-text">5</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Lokasi COD</div>
                            </div>
                        </div>
                    </div>

                    <!-- Right - Illustration Cards -->
                    <div class="relative hidden lg:block">
                        <div class="relative w-full h-[500px]">
                            <!-- Card 1 -->
                            <div class="absolute top-0 left-10 w-64 bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-4 floating">
                                <div class="h-32 bg-gradient-to-br from-indigo-100 to-purple-100 dark:from-indigo-900/50 dark:to-purple-900/50 rounded-xl mb-3 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                                <p class="font-semibold text-gray-800 dark:text-white">Buku Kalkulus</p>
                                <p class="text-sm text-gray-500">Rp 45.000</p>
                                <div class="flex items-center mt-2 text-xs text-indigo-600">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>
                                    Kampus Pusat
                                </div>
                            </div>

                            <!-- Card 2 -->
                            <div class="absolute top-20 right-0 w-64 bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-4 floating-delay">
                                <div class="h-32 bg-gradient-to-br from-green-100 to-teal-100 dark:from-green-900/50 dark:to-teal-900/50 rounded-xl mb-3 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <p class="font-semibold text-gray-800 dark:text-white">Laptop Bekas</p>
                                <p class="text-sm text-gray-500">Rp 2.500.000</p>
                                <div class="flex items-center mt-2 text-xs text-green-600">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>
                                    Gegerkalong
                                </div>
                            </div>

                            <!-- Card 3 -->
                            <div class="absolute bottom-10 left-20 w-64 bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-4 floating-delay-2">
                                <div class="h-32 bg-gradient-to-br from-orange-100 to-yellow-100 dark:from-orange-900/50 dark:to-yellow-900/50 rounded-xl mb-3 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                </div>
                                <p class="font-semibold text-gray-800 dark:text-white">Meja Belajar Lipat</p>
                                <p class="text-sm text-gray-500">Rp 150.000</p>
                                <div class="flex items-center mt-2 text-xs text-orange-600">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>
                                    Asrama Putra
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-20 bg-gray-50 dark:bg-gray-800/50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl sm:text-4xl font-bold mb-4">
                        Kenapa <span class="gradient-text">Lungsurin</span>?
                    </h2>
                    <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                        Platform yang dirancang khusus untuk kebutuhan mahasiswa
                    </p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Feature 1 -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 card-hover border border-gray-100 dark:border-gray-700">
                        <div class="w-14 h-14 gradient-bg rounded-xl flex items-center justify-center mb-4 shadow-lg shadow-indigo-500/30">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">COD di Kampus</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Transaksi aman dengan sistem COD langsung di area kampus
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 card-hover border border-gray-100 dark:border-gray-700">
                        <div class="w-14 h-14 bg-gradient-to-r from-green-500 to-teal-500 rounded-xl flex items-center justify-center mb-4 shadow-lg shadow-green-500/30">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Khusus Mahasiswa</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Komunitas eksklusif sesama mahasiswa, lebih aman & terpercaya
                        </p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 card-hover border border-gray-100 dark:border-gray-700">
                        <div class="w-14 h-14 bg-gradient-to-r from-orange-500 to-yellow-500 rounded-xl flex items-center justify-center mb-4 shadow-lg shadow-orange-500/30">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Harga Kantong Mahasiswa</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Barang berkualitas dengan harga yang ramah di kantong
                        </p>
                    </div>

                    <!-- Feature 4 -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 card-hover border border-gray-100 dark:border-gray-700">
                        <div class="w-14 h-14 bg-gradient-to-r from-pink-500 to-rose-500 rounded-xl flex items-center justify-center mb-4 shadow-lg shadow-pink-500/30">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Chat via WhatsApp</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Langsung chat dengan penjual via WhatsApp untuk nego
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- How It Works -->
        <section class="py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl sm:text-4xl font-bold mb-4">
                        Cara Kerja <span class="gradient-text">Lungsurin</span>
                    </h2>
                    <p class="text-lg text-gray-600 dark:text-gray-400">
                        Tiga langkah mudah untuk mulai jual-beli
                    </p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Step 1 -->
                    <div class="text-center">
                        <div class="relative inline-flex items-center justify-center w-20 h-20 gradient-bg rounded-full mb-6 shadow-xl shadow-indigo-500/30">
                            <span class="text-3xl font-bold text-white">1</span>
                        </div>
                        <h3 class="text-xl font-semibold mb-3">Daftar Akun</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Buat akun gratis hanya dengan email. Proses cepat kurang dari 1 menit!
                        </p>
                    </div>

                    <!-- Step 2 -->
                    <div class="text-center">
                        <div class="relative inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-green-500 to-teal-500 rounded-full mb-6 shadow-xl shadow-green-500/30">
                            <span class="text-3xl font-bold text-white">2</span>
                        </div>
                        <h3 class="text-xl font-semibold mb-3">Upload Barang</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Foto barang, set harga, pilih lokasi COD. GPS otomatis mendeteksi posisi!
                        </p>
                    </div>

                    <!-- Step 3 -->
                    <div class="text-center">
                        <div class="relative inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-orange-500 to-yellow-500 rounded-full mb-6 shadow-xl shadow-orange-500/30">
                            <span class="text-3xl font-bold text-white">3</span>
                        </div>
                        <h3 class="text-xl font-semibold mb-3">COD & Selesai</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Pembeli chat via WhatsApp, ketemuan, transaksi selesai. Mudah kan?
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="gradient-bg rounded-3xl p-8 sm:p-12 text-center text-white relative overflow-hidden">
                    <!-- Decorative -->
                    <div class="absolute top-0 left-0 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
                    <div class="absolute bottom-0 right-0 w-60 h-60 bg-white/10 rounded-full blur-2xl"></div>
                    
                    <div class="relative z-10">
                        <h2 class="text-3xl sm:text-4xl font-bold mb-4">
                            Siap Jual Barang Bekasmu?
                        </h2>
                        <p class="text-lg text-white/80 mb-8 max-w-xl mx-auto">
                            Gabung sekarang dan mulai jualan ke sesama mahasiswa. Gratis, cepat, dan aman!
                        </p>
                        @auth
                            <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center px-8 py-4 text-base font-semibold text-indigo-600 bg-white rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1">
                                Ke Dashboard
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-8 py-4 text-base font-semibold text-indigo-600 bg-white rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1">
                                Daftar Gratis Sekarang
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 gradient-bg rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                        <span class="font-bold gradient-text">{{ config('app.name', 'LUNGSURIN') }}</span>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        &copy; {{ date('Y') }} Lungsurin. Made with ❤️ for Mahasiswa.
                    </p>
                </div>
            </div>
        </footer>
    </body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'LUNGSURIN') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .gradient-bg {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }
            .glass-card {
                background: rgba(15, 23, 42, 0.85);
                backdrop-filter: blur(20px);
                border: 1px solid rgba(99, 102, 241, 0.25);
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4), 0 0 0 1px rgba(99, 102, 241, 0.1);
            }
            .floating {
                animation: floating 3s ease-in-out infinite;
            }
            @keyframes floating {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-10px); }
            }
            .pulse-slow {
                animation: pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
            }
            .slide-up {
                animation: slideUp 0.6s ease-out forwards;
            }
            @keyframes slideUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            @keyframes gradientShift {
                0% {
                    background-position: 0% 50%;
                }
                50% {
                    background-position: 100% 50%;
                }
                100% {
                    background-position: 0% 50%;
                }
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex">
            <!-- Left Side - Illustration -->
            <div class="hidden lg:flex lg:w-1/2 gradient-bg relative overflow-hidden">
                <!-- Decorative circles -->
                <div class="absolute top-20 left-20 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-20 right-20 w-96 h-96 bg-purple-300/20 rounded-full blur-3xl"></div>
                
                <!-- Content -->
                <div class="relative z-10 flex flex-col items-center justify-center w-full p-12 text-white">
                    <!-- Logo Icon -->
                    <div class="floating mb-8">
                        <div class="w-24 h-24 bg-white/20 backdrop-blur rounded-3xl flex items-center justify-center shadow-2xl">
                            <svg class="w-14 h-14 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                    </div>

                    <h1 class="text-4xl font-bold mb-4 text-center">{{ config('app.name', 'LUNGSURIN') }}</h1>
                    <p class="text-xl text-white/80 text-center max-w-md mb-8">
                        Marketplace barang bekas mahasiswa. Jual-beli mudah, COD di kampus!
                    </p>

                    <!-- Features -->
                    <div class="space-y-4 w-full max-w-sm">
                        <div class="flex items-center gap-4 bg-white/10 backdrop-blur rounded-xl p-4">
                            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold">COD di Kampus</p>
                                <p class="text-sm text-white/70">Transaksi aman, ketemu langsung</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 bg-white/10 backdrop-blur rounded-xl p-4">
                            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold">Harga Mahasiswa</p>
                                <p class="text-sm text-white/70">Barang berkualitas, harga terjangkau</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 bg-white/10 backdrop-blur rounded-xl p-4">
                            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold">Komunitas Kampus</p>
                                <p class="text-sm text-white/70">Eksklusif untuk mahasiswa</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bottom wave -->
                <div class="absolute bottom-0 left-0 right-0">
                    <svg viewBox="0 0 1440 120" class="w-full h-20 text-white/5">
                        <path fill="currentColor" d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z"></path>
                    </svg>
                </div>
            </div>

            <!-- Right Side - Form -->
            <div class="w-full lg:w-1/2 flex flex-col items-center justify-center p-6 sm:p-12 relative overflow-hidden" style="background: linear-gradient(135deg, #1e3a5f 0%, #2d4a6e 25%, #1a2a3a 50%, #0f1b2e 75%, #1e3a5f 100%); background-size: 400% 400%; animation: gradientShift 15s ease infinite;">
                <!-- Animated Background Blobs -->
                <div class="absolute top-0 -right-20 w-96 h-96 bg-indigo-500/20 rounded-full blur-3xl pulse-slow"></div>
                <div class="absolute bottom-0 -left-20 w-96 h-96 bg-purple-500/20 rounded-full blur-3xl pulse-slow" style="animation-delay: -2s;"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-gradient-to-r from-indigo-400/10 to-purple-400/10 rounded-full blur-3xl floating"></div>
                <div class="absolute top-20 right-10 w-64 h-64 bg-blue-400/15 rounded-full blur-2xl pulse-slow" style="animation-delay: -4s;"></div>
                <div class="absolute bottom-20 left-10 w-64 h-64 bg-cyan-400/15 rounded-full blur-2xl pulse-slow" style="animation-delay: -6s;"></div>
                
                <!-- Mobile Logo -->
                <div class="lg:hidden mb-8 text-center relative z-10">
                    <div class="inline-flex items-center gap-3">
                        <div class="w-12 h-12 gradient-bg rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                        <span class="text-2xl font-bold text-white">{{ config('app.name', 'LUNGSURIN') }}</span>
                    </div>
                </div>

                <!-- Card -->
                <div class="w-full max-w-md slide-up relative z-10">
                <div class="glass-card dark:bg-gradient-to-br dark:from-gray-800 dark:via-gray-800 dark:to-gray-900 dark:border-indigo-800/30 rounded-3xl shadow-2xl p-6 sm:p-8">
                        {{ $slot }}
                    </div>

                    <!-- Back to home -->
                    <div class="mt-6 text-center relative z-10">
                        <a href="/" class="inline-flex items-center text-sm text-white/80 hover:text-white transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Kembali ke beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

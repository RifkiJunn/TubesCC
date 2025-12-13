<x-app-layout>
    @php
        $sellerPhone = $product->user->phone;
        $whatsappUrl = "#";
        $hasPhone = false;

        if ($sellerPhone) {
            $hasPhone = true;
            $cleanPhone = preg_replace('/[^0-9]/', '', $sellerPhone);
            
            if (substr($cleanPhone, 0, 1) == '0') {
                $cleanPhone = '62' . substr($cleanPhone, 1);
            } else if (substr($cleanPhone, 0, 2) != '62') {
                $cleanPhone = '62' . $cleanPhone;
            }

            $text = "Halo " . $product->user->name . ", saya tertarik dengan barang *" . $product->title . "* yang dijual di Lungsurin.";
            $whatsappUrl = "https://wa.me/" . $cleanPhone . "?text=" . urlencode($text);
        }
    @endphp

    <div class="py-8 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Breadcrumb -->
            <nav class="flex items-center gap-2 mb-6 text-sm">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-1 text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Dashboard
                </a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-gray-800 dark:text-white font-medium truncate max-w-xs">{{ $product->title }}</span>
            </nav>

            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2">
                    
                    <!-- Image Section -->
                    <div class="relative bg-gray-100 dark:bg-gray-900 min-h-[350px] lg:min-h-[500px]">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" class="absolute inset-0 w-full h-full object-cover">
                        @else
                            <div class="absolute inset-0 flex flex-col items-center justify-center text-gray-400">
                                <svg class="w-20 h-20 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-sm">Tidak ada foto</span>
                            </div>
                        @endif

                        <!-- Gradient Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent"></div>

                        <!-- Map Button -->
                        @if($product->latitude && $product->longitude)
                            <a href="https://www.google.com/maps/search/?api=1&query={{ $product->latitude }},{{ $product->longitude }}" 
                               target="_blank"
                               class="absolute bottom-4 left-4 inline-flex items-center gap-2 px-4 py-2.5 bg-white/95 dark:bg-gray-800/95 backdrop-blur-sm rounded-xl text-gray-800 dark:text-white font-medium shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5">
                                <span class="w-6 h-6 bg-red-500 rounded-full flex items-center justify-center animate-pulse">
                                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    </svg>
                                </span>
                                Lihat di Google Maps
                            </a>
                        @endif
                    </div>

                    <!-- Info Section -->
                    <div class="p-6 sm:p-8 lg:p-10 flex flex-col">
                        <!-- Seller Info -->
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full flex items-center justify-center text-white text-lg font-bold shadow-lg">
                                    {{ substr($product->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold">Penjual</p>
                                    <p class="font-bold text-gray-800 dark:text-white">{{ $product->user->name }}</p>
                                </div>
                            </div>
                            <span class="text-xs text-gray-400">{{ $product->created_at->diffForHumans() }}</span>
                        </div>

                        <!-- Location Badge -->
                        @if($product->campus_location)
                        <div class="mb-4">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-50 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300 rounded-full text-sm font-medium">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                                </svg>
                                COD: {{ $product->campus_location }}
                            </span>
                        </div>
                        @endif

                        <!-- Title & Price -->
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 dark:text-white mb-3 leading-tight">
                            {{ $product->title }}
                        </h1>
                        <p class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent mb-6">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>

                        <!-- Description -->
                        <div class="flex-1 mb-8">
                            <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Deskripsi</h3>
                            <div class="prose prose-sm dark:prose-invert max-w-none">
                                <p class="text-gray-600 dark:text-gray-300 leading-relaxed whitespace-pre-line">{{ $product->description }}</p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="border-t border-gray-100 dark:border-gray-700 pt-6 space-y-3">
                            <p class="text-center text-sm text-gray-500 dark:text-gray-400 mb-4">Tertarik? Hubungi penjual langsung!</p>
                            
                            @if($hasPhone)
                                <a href="{{ $whatsappUrl }}" target="_blank" 
                                   class="flex items-center justify-center gap-2 w-full py-4 bg-green-500 hover:bg-green-600 text-white font-bold rounded-xl shadow-lg shadow-green-500/30 hover:shadow-xl transition transform hover:-translate-y-0.5">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                                    </svg>
                                    Chat via WhatsApp
                                </a>
                            @else
                                <button disabled class="flex items-center justify-center gap-2 w-full py-4 bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 font-bold rounded-xl cursor-not-allowed">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                    Penjual belum input No. WA
                                </button>
                                <p class="text-xs text-center text-gray-500 dark:text-gray-400">Penjual belum melengkapi nomor WhatsApp di profil.</p>
                            @endif

                            <a href="mailto:{{ $product->user->email }}" 
                               class="flex items-center justify-center gap-2 w-full py-3.5 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-xl hover:bg-gray-50 dark:hover:bg-gray-600 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                Kirim Email
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

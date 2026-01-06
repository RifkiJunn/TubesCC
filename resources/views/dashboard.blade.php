<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
                    Halo, {{ Auth::user()->name }}! 👋
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Selamat datang di dashboard Lungsurin</p>
            </div>
            
            @php
                $usedSlots = $myProducts->where('status', 'available')->count();
                $limit = Auth::user()->product_limit ?? 3;
                $percentage = ($limit > 0) ? ($usedSlots / $limit) * 100 : 100;
            @endphp

            <div class="flex items-center gap-3 bg-white dark:bg-gray-800 px-4 py-3 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="text-right hidden sm:block">
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Kuota Barang</p>
                    <p class="text-sm font-bold text-gray-800 dark:text-white">{{ $usedSlots }}/{{ $limit }} Slot</p>
                </div>
                
                <div class="w-20 h-2.5 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                    <div class="h-full rounded-full transition-all duration-500 {{ $percentage >= 100 ? 'bg-red-500' : ($percentage >= 70 ? 'bg-yellow-500' : 'bg-green-500') }}" 
                         style="width: {{ min($percentage, 100) }}%"></div>
                </div>

                <a href="{{ route('slots.index') }}" class="bg-gradient-to-r from-yellow-400 to-orange-400 hover:from-yellow-500 hover:to-orange-500 text-white text-xs font-bold px-3 py-2 rounded-lg transition shadow-sm flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    <span class="hidden sm:inline">Beli Slot</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <!-- SECTION: MARKETPLACE -->
            <div>
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-white flex items-center gap-2">
                            <svg class="w-7 h-7 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            Lungsuran Kampus
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Temukan barang bekas dari mahasiswa lain</p>
                    </div>
                </div>

                <!-- FILTER SECTION -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-4 mb-6">
                    <form method="GET" action="{{ route('dashboard') }}" id="filterForm">
                        <div class="flex flex-col lg:flex-row gap-4">
                            <!-- Search -->
                            <div class="flex-1">
                                <div class="relative">
                                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                    <input 
                                        type="text" 
                                        name="search" 
                                        value="{{ request('search') }}"
                                        placeholder="Cari barang..." 
                                        class="w-full pl-12 pr-4 py-3 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition text-gray-800 dark:text-white placeholder-gray-400"
                                    >
                                </div>
                            </div>

                            <!-- Location Filter -->
                            <div class="w-full lg:w-56">
                                <select name="location" onchange="document.getElementById('filterForm').submit()" class="w-full py-3 px-4 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition text-gray-800 dark:text-white">
                                    <option value="">📍 Semua Lokasi</option>
                                    <option value="Kampus Pusat (Buah Batu)" {{ request('location') == 'Kampus Pusat (Buah Batu)' ? 'selected' : '' }}>Kampus Pusat (Buah Batu)</option>
                                    <option value="Kampus Gegerkalong" {{ request('location') == 'Kampus Gegerkalong' ? 'selected' : '' }}>Kampus Gegerkalong</option>
                                    <option value="Asrama Putra" {{ request('location') == 'Asrama Putra' ? 'selected' : '' }}>Asrama Putra</option>
                                    <option value="Asrama Putri" {{ request('location') == 'Asrama Putri' ? 'selected' : '' }}>Asrama Putri</option>
                                    <option value="Luar Kampus (COD Terdekat)" {{ request('location') == 'Luar Kampus (COD Terdekat)' ? 'selected' : '' }}>Luar Kampus</option>
                                </select>
                            </div>

                            <!-- Price Filter -->
                            <div class="w-full lg:w-48">
                                <select name="price_range" onchange="document.getElementById('filterForm').submit()" class="w-full py-3 px-4 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition text-gray-800 dark:text-white">
                                    <option value="">💰 Semua Harga</option>
                                    <option value="0-50000" {{ request('price_range') == '0-50000' ? 'selected' : '' }}>< Rp 50.000</option>
                                    <option value="50000-100000" {{ request('price_range') == '50000-100000' ? 'selected' : '' }}>Rp 50K - 100K</option>
                                    <option value="100000-500000" {{ request('price_range') == '100000-500000' ? 'selected' : '' }}>Rp 100K - 500K</option>
                                    <option value="500000-1000000" {{ request('price_range') == '500000-1000000' ? 'selected' : '' }}>Rp 500K - 1Jt</option>
                                    <option value="1000000-999999999" {{ request('price_range') == '1000000-999999999' ? 'selected' : '' }}>> Rp 1 Juta</option>
                                </select>
                            </div>

                            <!-- Sort -->
                            <div class="w-full lg:w-44">
                                <select name="sort" onchange="document.getElementById('filterForm').submit()" class="w-full py-3 px-4 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition text-gray-800 dark:text-white">
                                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>🕐 Terbaru</option>
                                    <option value="cheapest" {{ request('sort') == 'cheapest' ? 'selected' : '' }}>💵 Termurah</option>
                                    <option value="expensive" {{ request('sort') == 'expensive' ? 'selected' : '' }}>💎 Termahal</option>
                                </select>
                            </div>

                            <!-- Search Button -->
                            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg shadow-indigo-500/30 transition transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <span class="hidden sm:inline">Cari</span>
                            </button>
                        </div>

                        <!-- Active Filters -->
                        @if(request('search') || request('location') || request('price_range'))
                        <div class="flex flex-wrap items-center gap-2 mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                            <span class="text-sm text-gray-500">Filter aktif:</span>
                            
                            @if(request('search'))
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-indigo-100 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300 rounded-full text-sm">
                                "{{ request('search') }}"
                                <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="hover:text-indigo-900">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </a>
                            </span>
                            @endif
                            
                            @if(request('location'))
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 dark:bg-green-900/50 text-green-700 dark:text-green-300 rounded-full text-sm">
                                📍 {{ request('location') }}
                                <a href="{{ request()->fullUrlWithQuery(['location' => null]) }}" class="hover:text-green-900">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </a>
                            </span>
                            @endif
                            
                            @if(request('price_range'))
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-yellow-100 dark:bg-yellow-900/50 text-yellow-700 dark:text-yellow-300 rounded-full text-sm">
                                💰 {{ request('price_range') }}
                                <a href="{{ request()->fullUrlWithQuery(['price_range' => null]) }}" class="hover:text-yellow-900">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </a>
                            </span>
                            @endif

                            <a href="{{ route('dashboard') }}" class="text-sm text-red-500 hover:text-red-700 font-medium ml-2">
                                Hapus Semua
                            </a>
                        </div>
                        @endif
                    </form>
                </div>

                <!-- Products Grid -->
                @if($marketProducts->isEmpty())
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-12 text-center">
                        <div class="w-20 h-20 mx-auto mb-4 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">Belum Ada Barang</h4>
                        <p class="text-gray-500 dark:text-gray-400">
                            @if(request()->hasAny(['search', 'location', 'price_range']))
                                Tidak ada barang yang cocok dengan filter. Coba ubah filter pencarian.
                            @else
                                Belum ada barang dari mahasiswa lain. Yuk jadi yang pertama jual!
                            @endif
                        </p>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($marketProducts as $product)
                            <a href="{{ route('products.show', $product) }}" class="group bg-white dark:bg-gray-800 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-gray-700 overflow-hidden transform hover:-translate-y-1">
                                <div class="relative aspect-[4/3] bg-gray-100 dark:bg-gray-900 overflow-hidden">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    @else
                                        <div class="flex items-center justify-center h-full">
                                            <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    
                                    <!-- Location Badge -->
                                    @if($product->campus_location)
                                    <div class="absolute top-3 left-3">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-lg text-xs font-medium text-gray-700 dark:text-gray-300 shadow-sm">
                                            <svg class="w-3 h-3 text-indigo-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>
                                            {{ Str::limit($product->campus_location, 15) }}
                                        </span>
                                    </div>
                                    @endif

                                    <!-- GPS Indicator -->
                                    @if($product->latitude && $product->longitude)
                                    <div class="absolute top-3 right-3">
                                        <span class="inline-flex items-center justify-center w-8 h-8 bg-green-500 rounded-full shadow-lg" title="GPS Tersedia">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            </svg>
                                        </span>
                                    </div>
                                    @endif
                                </div>
                                
                                <div class="p-4">
                                    <div class="flex items-center gap-2 mb-2">
                                        <div class="w-6 h-6 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                            {{ substr($product->user->name, 0, 1) }}
                                        </div>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ $product->user->name }}</span>
                                    </div>
                                    
                                    <h4 class="font-bold text-gray-800 dark:text-white truncate group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                        {{ $product->title }}
                                    </h4>
                                    
                                    <div class="mt-3 flex items-center justify-between">
                                        <span class="text-lg font-bold text-indigo-600 dark:text-indigo-400">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </span>
                                        <span class="text-xs text-gray-400">
                                            {{ $product->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <hr class="border-gray-200 dark:border-gray-700">

            <!-- SECTION: LAPAK SAYA -->
            <div>
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white flex items-center gap-2">
                            <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            Lapak Saya
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Kelola barang yang kamu jual</p>
                    </div>
                    
                    @if($usedSlots < $limit)
                        <a href="{{ route('products.create') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg shadow-indigo-500/30 transition transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Jual Barang
                        </a>
                    @else
                        <button disabled class="inline-flex items-center px-5 py-2.5 bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 font-semibold rounded-xl cursor-not-allowed">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                            </svg>
                            Slot Penuh
                        </button>
                    @endif
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                    @if($myProducts->isEmpty())
                        <div class="p-12 text-center">
                            <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                            <p class="text-gray-500 dark:text-gray-400 mb-4">Kamu belum menjual barang apapun</p>
                            @if($usedSlots < $limit)
                            <a href="{{ route('products.create') }}" class="inline-flex items-center text-indigo-600 dark:text-indigo-400 font-semibold hover:underline">
                                Mulai jual barang pertamamu
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                            @endif
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-900">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Barang</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Harga</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Lokasi</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
                                    @foreach($myProducts as $item)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    @if($item->image)
                                                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="w-12 h-12 object-cover rounded-lg">
                                                    @else
                                                        <div class="w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <p class="font-semibold text-gray-800 dark:text-white">{{ $item->title }}</p>
                                                        <p class="text-xs text-gray-500">{{ $item->created_at->format('d M Y') }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="font-semibold text-gray-800 dark:text-white">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ $item->campus_location ?? '-' }}</span>
                                            </td>
                                            <td class="px-6 py-4">
                                                @if($item->status == 'available')
                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 dark:bg-green-900/50 text-green-700 dark:text-green-300">
                                                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5 animate-pulse"></span>
                                                        Aktif
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400">
                                                        {{ ucfirst($item->status) }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-right space-x-2">
                                                <div class="flex items-center justify-end gap-2">
                                                    <!-- Toggle Status Form -->
                                                    <form action="{{ route('products.status', $item->id) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" 
                                                            class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-lg transition border {{ $item->status == 'available' ? 'border-green-200 text-green-700 hover:bg-green-50' : 'border-gray-200 text-gray-600 hover:bg-gray-50' }}"
                                                            title="{{ $item->status == 'available' ? 'Tandai Terjual' : 'Tandai Tersedia' }}">
                                                            @if($item->status == 'available')
                                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                                Mark Sold
                                                            @else
                                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                                                Restock
                                                            @endif
                                                        </button>
                                                    </form>

                                                    <a href="{{ route('products.edit', $item->id) }}" class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 rounded-lg transition">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                        </svg>
                                                        Edit
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

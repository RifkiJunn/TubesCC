<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('dashboard') }}" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Jual Barang</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Posting barang bekas kamu untuk dijual</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-6 sm:p-8">
                    
                    <!-- Reminder untuk mengisi nomor HP -->
                    @if (empty(auth()->user()->phone))
                        <div class="mb-6 bg-amber-50 dark:bg-amber-900/30 border-l-4 border-amber-500 p-5 rounded-r-lg">
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-amber-800 dark:text-amber-200 mb-1">Nomor HP Belum Diisi</h3>
                                    <p class="text-sm text-amber-700 dark:text-amber-300 mb-3">
                                        Untuk memudahkan pembeli menghubungi kamu, silakan lengkapi nomor HP di profil terlebih dahulu.
                                    </p>
                                    <a href="{{ route('profile.edit') }}" 
                                        class="inline-flex items-center gap-2 px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white font-medium rounded-lg transition-colors text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        Lengkapi Profil Sekarang
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 p-4 rounded-r-lg">
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="font-semibold text-red-800 dark:text-red-200">Ada kesalahan:</p>
                            </div>
                            <ul class="list-disc list-inside text-sm text-red-700 dark:text-red-300 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- Nama Barang -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Nama Barang <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="title" value="{{ old('title') }}" required
                                placeholder="Contoh: Meja Belajar Lipat"
                                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition text-gray-800 dark:text-white placeholder-gray-400">
                        </div>

                        <!-- Harga dan Foto -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Harga <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-500 font-medium">Rp</span>
                                    <input type="number" name="price" value="{{ old('price') }}" required min="1000"
                                        placeholder="50000"
                                        class="w-full pl-12 pr-4 py-3 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition text-gray-800 dark:text-white placeholder-gray-400">
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Foto Barang
                                </label>
                                <input type="file" name="image" accept="image/*"
                                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 dark:file:bg-indigo-900/50 file:text-indigo-700 dark:file:text-indigo-300 hover:file:bg-indigo-100 dark:hover:file:bg-indigo-900 transition cursor-pointer">
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Deskripsi & Kondisi <span class="text-red-500">*</span>
                            </label>
                            <textarea name="description" rows="4" required
                                placeholder="Jelaskan kondisi barang, minus pemakaian, alasan jual, dll."
                                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition text-gray-800 dark:text-white placeholder-gray-400 resize-none">{{ old('description') }}</textarea>
                        </div>
                        
                        <!-- Lokasi : Provinsi & Kota -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Provinsi <span class="text-red-500">*</span>
                                </label>
                                <select id="province-select" required
                                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition text-gray-800 dark:text-white">
                                    <option value="" disabled selected>-- Pilih Provinsi --</option>
                                    <!-- Options populated by JS -->
                                </select>
                                <input type="hidden" name="province" id="province-input">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Kota/Kabupaten <span class="text-red-500">*</span>
                                </label>
                                <select id="city-select" required disabled
                                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition text-gray-800 dark:text-white disabled:opacity-50 disabled:cursor-not-allowed">
                                    <option value="" disabled selected>-- Pilih Kota --</option>
                                    <!-- Options populated by JS -->
                                </select>
                                <input type="hidden" name="city" id="city-input">
                            </div>
                        </div>

                        <!-- GPS Location -->
                        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 p-5 rounded-2xl border border-indigo-100 dark:border-indigo-800">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-10 h-10 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center shadow">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800 dark:text-white">Lokasi GPS (Opsional)</h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Bantu pembeli menemukan lokasi COD</p>
                                </div>
                            </div>
                            
                            <div class="flex flex-col sm:flex-row gap-3">
                                <button type="button" onclick="getLocation()" 
                                    class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-700 dark:text-gray-300 font-medium hover:border-indigo-500 hover:text-indigo-600 transition shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    </svg>
                                    Ambil Lokasi Saya
                                </button>
                                <span id="status-gps" class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Klik tombol untuk deteksi koordinat
                                </span>
                            </div>

                            <div class="grid grid-cols-2 gap-3 mt-4">
                                <input type="text" name="latitude" id="latitude" readonly
                                    placeholder="Latitude"
                                    class="bg-white/50 dark:bg-gray-800/50 border-none rounded-lg text-xs text-gray-500 dark:text-gray-400 px-3 py-2">
                                <input type="text" name="longitude" id="longitude" readonly
                                    placeholder="Longitude"
                                    class="bg-white/50 dark:bg-gray-800/50 border-none rounded-lg text-xs text-gray-500 dark:text-gray-400 px-3 py-2">
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100 dark:border-gray-700">
                            <a href="{{ route('dashboard') }}" class="px-5 py-2.5 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white font-medium transition">
                                Batal
                            </a>
                            <button type="submit" 
                                class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg shadow-indigo-500/30 hover:shadow-xl transition transform hover:-translate-y-0.5">
                                Posting Sekarang
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        // API Base URL
        const apiBaseUrl = 'https://www.emsifa.com/api-wilayah-indonesia/api';

        const provinceSelect = document.getElementById('province-select');
        const citySelect = document.getElementById('city-select');
        const provinceInput = document.getElementById('province-input');
        const cityInput = document.getElementById('city-input');

        // Fetch Provinces
        fetch(`${apiBaseUrl}/provinces.json`)
            .then(response => response.json())
            .then(provinces => {
                provinces.forEach(province => {
                    const option = document.createElement('option');
                    option.value = province.id;
                    option.text = province.name;
                    provinceSelect.appendChild(option);
                });
            });

        // On Province Change
        provinceSelect.addEventListener('change', function() {
            const provinceId = this.value;
            const provinceName = this.options[this.selectedIndex].text;
            
            // Set hidden input
            provinceInput.value = provinceName;

            // Enable city select and clear options
            citySelect.disabled = false;
            citySelect.innerHTML = '<option value="" disabled selected>-- Pilih Kota --</option>';
            cityInput.value = ''; // Reset city

            // Fetch Cities
            fetch(`${apiBaseUrl}/regencies/${provinceId}.json`)
                .then(response => response.json())
                .then(cities => {
                    cities.forEach(city => {
                        const option = document.createElement('option');
                        option.value = city.id;
                        option.text = city.name;
                        citySelect.appendChild(option);
                    });
                });
        });

        // On City Change
        citySelect.addEventListener('change', function() {
            const cityName = this.options[this.selectedIndex].text;
            cityInput.value = cityName;
        });

        function getLocation() {
            const status = document.getElementById('status-gps');
            const latInput = document.getElementById('latitude');
            const longInput = document.getElementById('longitude');

            if (!navigator.geolocation) {
                status.innerHTML = '<svg class="w-4 h-4 mr-1.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg> Browser tidak mendukung GPS';
                status.className = "flex items-center text-sm text-red-600 font-medium";
                return;
            }

            status.innerHTML = '<svg class="w-4 h-4 mr-1.5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg> Mencari lokasi...';
            status.className = "flex items-center text-sm text-indigo-600 font-medium";

            navigator.geolocation.getCurrentPosition(
                (position) => {
                    latInput.value = position.coords.latitude;
                    longInput.value = position.coords.longitude;
                    
                    status.innerHTML = '<svg class="w-4 h-4 mr-1.5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Lokasi berhasil diambil!';
                    status.className = "flex items-center text-sm text-green-600 font-semibold";
                },
                (error) => {
                    let msg = "Gagal mengambil lokasi";
                    if(error.code == 1) msg = "Izin lokasi ditolak";
                    else if(error.code == 2) msg = "Sinyal GPS tidak tersedia";
                    else if(error.code == 3) msg = "Waktu permintaan habis";
                    
                    status.innerHTML = '<svg class="w-4 h-4 mr-1.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg> ' + msg;
                    status.className = "flex items-center text-sm text-red-600 font-medium";
                }
            );
        }
    </script>
</x-app-layout>

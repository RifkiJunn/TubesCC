<section>
    <form method="post" action="{{ route('profile.location.update') }}" class="space-y-5">
        @csrf
        @method('patch')

        <!-- Kota -->
        <div>
            <label for="city" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                Kota <span class="text-red-500">*</span>
            </label>
            <select id="city" name="city" required
                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition text-gray-800 dark:text-white">
                <option value="" disabled {{ !$user->city ? 'selected' : '' }}>-- Pilih Kota --</option>
                <option value="Bandung" {{ $user->city == 'Bandung' ? 'selected' : '' }}>Bandung</option>
                <option value="Jakarta" {{ $user->city == 'Jakarta' ? 'selected' : '' }}>Jakarta</option>
                <option value="Surabaya" {{ $user->city == 'Surabaya' ? 'selected' : '' }}>Surabaya</option>
                <option value="Yogyakarta" {{ $user->city == 'Yogyakarta' ? 'selected' : '' }}>Yogyakarta</option>
                <option value="Semarang" {{ $user->city == 'Semarang' ? 'selected' : '' }}>Semarang</option>
                <option value="Malang" {{ $user->city == 'Malang' ? 'selected' : '' }}>Malang</option>
                <option value="Medan" {{ $user->city == 'Medan' ? 'selected' : '' }}>Medan</option>
                <option value="Makassar" {{ $user->city == 'Makassar' ? 'selected' : '' }}>Makassar</option>
                <option value="Depok" {{ $user->city == 'Depok' ? 'selected' : '' }}>Depok</option>
                <option value="Bogor" {{ $user->city == 'Bogor' ? 'selected' : '' }}>Bogor</option>
                <option value="Tangerang" {{ $user->city == 'Tangerang' ? 'selected' : '' }}>Tangerang</option>
                <option value="Bekasi" {{ $user->city == 'Bekasi' ? 'selected' : '' }}>Bekasi</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('city')" />
        </div>

        <!-- Kampus -->
        <div>
            <label for="campus" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                Kampus / Universitas <span class="text-red-500">*</span>
            </label>
            <input id="campus" name="campus" type="text" required
                value="{{ old('campus', $user->campus) }}"
                placeholder="Contoh: Telkom University, ITB, UI, UGM, dll"
                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition text-gray-800 dark:text-white">
            <x-input-error class="mt-2" :messages="$errors->get('campus')" />
        </div>

        <!-- Default COD Location -->
        <div>
            <label for="default_location" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                Lokasi COD Default
            </label>
            <select id="default_location" name="default_location"
                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition text-gray-800 dark:text-white">
                <option value="" {{ !$user->default_location ? 'selected' : '' }}>-- Pilih Lokasi COD --</option>
                <option value="Kampus Pusat (Buah Batu)" {{ $user->default_location == 'Kampus Pusat (Buah Batu)' ? 'selected' : '' }}>Kampus Pusat (Buah Batu)</option>
                <option value="Kampus Gegerkalong" {{ $user->default_location == 'Kampus Gegerkalong' ? 'selected' : '' }}>Kampus Gegerkalong</option>
                <option value="Asrama Putra" {{ $user->default_location == 'Asrama Putra' ? 'selected' : '' }}>Asrama Putra</option>
                <option value="Asrama Putri" {{ $user->default_location == 'Asrama Putri' ? 'selected' : '' }}>Asrama Putri</option>
                <option value="Luar Kampus (COD Terdekat)" {{ $user->default_location == 'Luar Kampus (COD Terdekat)' ? 'selected' : '' }}>Luar Kampus (COD Terdekat)</option>
            </select>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1.5">Lokasi ini akan otomatis terisi saat kamu jual barang baru</p>
            <x-input-error class="mt-2" :messages="$errors->get('default_location')" />
        </div>

        <!-- Info Box -->
        <div class="bg-gradient-to-r from-green-50 to-teal-50 dark:from-green-900/20 dark:to-teal-900/20 rounded-xl p-4 border border-green-100 dark:border-green-800">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-green-800 dark:text-green-300">Kenapa lokasi penting?</p>
                    <p class="text-xs text-green-700 dark:text-green-400 mt-1">
                        Pembeli bisa filter barang berdasarkan lokasi. Barang dari kota/kampus yang sama akan lebih mudah ditemukan!
                    </p>
                </div>
            </div>
        </div>

        <!-- Submit -->
        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-green-500 to-teal-500 hover:from-green-600 hover:to-teal-600 text-white font-semibold rounded-xl shadow-lg shadow-green-500/30 transition transform hover:-translate-y-0.5">
                Simpan Lokasi
            </button>

            @if (session('status') === 'location-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                   class="text-sm text-green-600 dark:text-green-400 font-medium flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Tersimpan!
                </p>
            @endif
        </div>
    </form>
</section>

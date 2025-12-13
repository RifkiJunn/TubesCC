<section>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
        @csrf
        @method('patch')

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                Nama Lengkap
            </label>
            <input id="name" name="name" type="text" required autofocus autocomplete="name"
                value="{{ old('name', $user->name) }}"
                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition text-gray-800 dark:text-white">
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                Email
            </label>
            <input id="email" name="email" type="email" required autocomplete="username"
                value="{{ old('email', $user->email) }}"
                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition text-gray-800 dark:text-white">
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-sm text-yellow-600 dark:text-yellow-400">
                        Email belum terverifikasi.
                        <button form="send-verification" class="underline hover:text-yellow-800 dark:hover:text-yellow-300">
                            Klik untuk kirim ulang verifikasi.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm text-green-600 dark:text-green-400">
                            Link verifikasi baru telah dikirim ke email kamu.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Phone/WhatsApp -->
        <div>
            <label for="phone" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                Nomor WhatsApp <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/>
                    </svg>
                </div>
                <input id="phone" name="phone" type="text" required
                    value="{{ old('phone', $user->phone) }}"
                    placeholder="08123456789"
                    class="w-full pl-12 pr-4 py-3 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition text-gray-800 dark:text-white">
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1.5">Pembeli akan menghubungi kamu via WhatsApp</p>
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <!-- Submit -->
        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg shadow-indigo-500/30 transition transform hover:-translate-y-0.5">
                Simpan Profil
            </button>

            @if (session('status') === 'profile-updated')
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

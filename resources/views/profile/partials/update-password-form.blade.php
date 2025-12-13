<section>
    <form method="post" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div>
            <label for="update_password_current_password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                Password Saat Ini
            </label>
            <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password"
                placeholder="Masukkan password saat ini"
                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition text-gray-800 dark:text-white">
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <!-- New Password -->
        <div>
            <label for="update_password_password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                Password Baru
            </label>
            <input id="update_password_password" name="password" type="password" autocomplete="new-password"
                placeholder="Minimal 8 karakter"
                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition text-gray-800 dark:text-white">
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="update_password_password_confirmation" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                Konfirmasi Password Baru
            </label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                placeholder="Ulangi password baru"
                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition text-gray-800 dark:text-white">
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Submit -->
        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-orange-500 to-yellow-500 hover:from-orange-600 hover:to-yellow-600 text-white font-semibold rounded-xl shadow-lg shadow-orange-500/30 transition transform hover:-translate-y-0.5">
                Ubah Password
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                   class="text-sm text-green-600 dark:text-green-400 font-medium flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Password diubah!
                </p>
            @endif
        </div>
    </form>
</section>

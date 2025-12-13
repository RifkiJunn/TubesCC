<section>
    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
        Setelah akun dihapus, semua data dan barang yang kamu jual akan hilang secara permanen. Pastikan kamu sudah yakin sebelum menghapus akun.
    </p>

    <button type="button"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="px-5 py-2.5 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-xl shadow-lg shadow-red-500/30 transition transform hover:-translate-y-0.5">
        Hapus Akun Saya
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-red-100 dark:bg-red-900/50 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                        Yakin hapus akun?
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Tindakan ini tidak bisa dibatalkan
                    </p>
                </div>
            </div>

            <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                Semua data termasuk barang yang kamu jual akan dihapus permanen. Masukkan password untuk konfirmasi.
            </p>

            <div class="mb-6">
                <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    Password
                </label>
                <input id="password" name="password" type="password"
                    placeholder="Masukkan password kamu"
                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent transition text-gray-800 dark:text-white">
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')"
                    class="px-5 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-semibold rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                    Batal
                </button>
                <button type="submit"
                    class="px-5 py-2.5 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-xl shadow-lg transition">
                    Ya, Hapus Akun
                </button>
            </div>
        </form>
    </x-modal>
</section>

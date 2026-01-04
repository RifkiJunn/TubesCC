<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                        </svg>
                    </div>
                    Daftar Pengguna
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 ml-13">Kelola semua akun yang terdaftar di sistem</p>
            </div>
            <div class="bg-white dark:bg-gray-800 px-4 py-3 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Total Pengguna</p>
                <p class="text-xl font-bold text-gray-800 dark:text-white">{{ $users->total() }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            {{-- Filter Section --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-4">
                <form method="GET" action="{{ route('admin.users.index') }}" id="filterForm">
                    <div class="flex flex-col lg:flex-row gap-4">
                        {{-- Search --}}
                        <div class="flex-1">
                            <div class="relative">
                                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <input 
                                    type="text" 
                                    name="search" 
                                    value="{{ request('search') }}"
                                    placeholder="Cari nama atau email..." 
                                    class="w-full pl-12 pr-4 py-3 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition text-gray-800 dark:text-white placeholder-gray-400"
                                >
                            </div>
                        </div>

                        {{-- Subscription Filter --}}
                        <div class="w-full lg:w-48">
                            <select name="subscription" onchange="document.getElementById('filterForm').submit()" class="w-full py-3 px-4 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition text-gray-800 dark:text-white">
                                <option value="">💎 Semua Status</option>
                                <option value="subscribed" {{ request('subscription') == 'subscribed' ? 'selected' : '' }}>✅ Subscribed</option>
                                <option value="not_subscribed" {{ request('subscription') == 'not_subscribed' ? 'selected' : '' }}>⏳ Not Subscribed</option>
                            </select>
                        </div>

                        {{-- Role Filter --}}
                        <div class="w-full lg:w-40">
                            <select name="role" onchange="document.getElementById('filterForm').submit()" class="w-full py-3 px-4 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition text-gray-800 dark:text-white">
                                <option value="">👥 Semua Role</option>
                                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>🛡️ Admin</option>
                                <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>👤 User</option>
                            </select>
                        </div>

                        {{-- Search Button --}}
                        <button type="submit" class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg shadow-indigo-500/30 transition transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <span class="hidden sm:inline">Cari</span>
                        </button>
                    </div>

                    {{-- Active Filters --}}
                    @if(request('search') || request('subscription') || request('role'))
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
                        
                        @if(request('subscription'))
                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 dark:bg-green-900/50 text-green-700 dark:text-green-300 rounded-full text-sm">
                            {{ request('subscription') == 'subscribed' ? '✅ Subscribed' : '⏳ Not Subscribed' }}
                            <a href="{{ request()->fullUrlWithQuery(['subscription' => null]) }}" class="hover:text-green-900">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </a>
                        </span>
                        @endif
                        
                        @if(request('role'))
                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-purple-100 dark:bg-purple-900/50 text-purple-700 dark:text-purple-300 rounded-full text-sm">
                            {{ request('role') == 'admin' ? '🛡️ Admin' : '👤 User' }}
                            <a href="{{ request()->fullUrlWithQuery(['role' => null]) }}" class="hover:text-purple-900">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </a>
                        </span>
                        @endif

                        <a href="{{ route('admin.users.index') }}" class="text-sm text-red-500 hover:text-red-700 font-medium ml-2">
                            Hapus Semua
                        </a>
                    </div>
                    @endif
                </form>
            </div>

            {{-- Users Table --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                @if($users->isEmpty())
                    <div class="p-12 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">Tidak Ada Pengguna</h4>
                        <p class="text-gray-500 dark:text-gray-400">
                            @if(request()->hasAny(['search', 'subscription', 'role']))
                                Tidak ada pengguna yang cocok dengan filter. Coba ubah pencarian.
                            @else
                                Belum ada pengguna yang terdaftar.
                            @endif
                        </p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-900">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Pengguna</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal Registrasi</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Role</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status Subscription</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
                                @foreach($users as $user)
                                    <tr onclick="window.location='{{ route('admin.users.show', $user) }}'" class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors cursor-pointer">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                @if($user->avatar)
                                                    <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="w-10 h-10 rounded-full object-cover">
                                                @else
                                                    <div class="w-10 h-10 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold shadow">
                                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                                    </div>
                                                @endif
                                                <div>
                                                    <p class="font-semibold text-gray-800 dark:text-white">{{ $user->name }}</p>
                                                    @if($user->campus)
                                                        <p class="text-xs text-gray-500">{{ $user->campus }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-gray-600 dark:text-gray-400">{{ $user->email }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-gray-600 dark:text-gray-400">{{ $user->created_at->format('d M Y') }}</span>
                                            <p class="text-xs text-gray-400">{{ $user->created_at->diffForHumans() }}</p>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($user->role === 'admin')
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-purple-100 dark:bg-purple-900/50 text-purple-700 dark:text-purple-300">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Admin
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                                    </svg>
                                                    User
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($user->product_limit > 3)
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 dark:bg-green-900/50 text-green-700 dark:text-green-300">
                                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5 animate-pulse"></span>
                                                    Subscribed ({{ $user->product_limit }} slot)
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400">
                                                    Not Subscribed
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    @if($users->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
                        {{ $users->links() }}
                    </div>
                    @endif
                @endif
            </div>

        </div>
    </div>
</x-app-layout>

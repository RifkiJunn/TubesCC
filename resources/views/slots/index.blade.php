<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
                    Beli Slot Listing
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Tambah kuota barang yang bisa kamu jual</p>
            </div>
            
            <div class="flex items-center gap-3 bg-white dark:bg-gray-800 px-4 py-3 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="text-right">
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Slot Saat Ini</p>
                    <p class="text-lg font-bold text-gray-800 dark:text-white">{{ $usedSlots }}/{{ $user->product_limit }} Slot</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            @if(session('success'))
            <div class="bg-green-100 dark:bg-green-900/50 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 px-4 py-3 rounded-xl">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-100 dark:bg-red-900/50 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 px-4 py-3 rounded-xl">
                {{ session('error') }}
            </div>
            @endif

            <!-- Purchase Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="bg-gradient-to-r from-yellow-400 to-orange-400 px-6 py-4">
                    <h3 class="text-xl font-bold text-white flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        Tambah Slot Permanen
                    </h3>
                </div>
                
                <div class="p-6">
                    <div class="text-center mb-6">
                        <p class="text-3xl font-bold text-gray-800 dark:text-white">Rp {{ number_format($slotPrice, 0, ',', '.') }}</p>
                        <p class="text-gray-500 dark:text-gray-400">per slot</p>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jumlah Slot</label>
                            <div class="flex items-center gap-4">
                                <button type="button" onclick="decreaseSlot()" class="w-12 h-12 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-xl flex items-center justify-center text-2xl font-bold text-gray-600 dark:text-gray-300 transition">
                                    -
                                </button>
                                <input type="number" id="slotCount" value="1" min="1" max="100" 
                                    class="flex-1 text-center text-2xl font-bold py-3 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-indigo-500 text-gray-800 dark:text-white"
                                    onchange="updateTotal()">
                                <button type="button" onclick="increaseSlot()" class="w-12 h-12 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-xl flex items-center justify-center text-2xl font-bold text-gray-600 dark:text-gray-300 transition">
                                    +
                                </button>
                            </div>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-900 rounded-xl p-4">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 dark:text-gray-400">Total Pembayaran</span>
                                <span id="totalPrice" class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">Rp {{ number_format($slotPrice, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <button type="button" onclick="buySlot()" id="buyButton"
                            class="w-full py-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/30 transition transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            Bayar Sekarang
                        </button>
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-100 dark:border-gray-700">
                        <h4 class="font-semibold text-gray-800 dark:text-white mb-3">Keuntungan Beli Slot:</h4>
                        <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                Slot berlaku permanen (tidak ada expire)
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                Bisa posting lebih banyak barang
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                Pembayaran aman via Midtrans
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Transaction History -->
            @if($transactions->count() > 0)
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">Riwayat Pembelian</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Order ID</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Slot</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Total</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach($transactions as $trx)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-white font-mono">{{ $trx->order_id }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-white">{{ $trx->slots_purchased }} slot</td>
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-white">Rp {{ number_format($trx->amount, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    @if($trx->status == 'success')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Sukses</span>
                                    @elseif($trx->status == 'pending')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">Pending</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">{{ ucfirst($trx->status) }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $trx->created_at->format('d M Y H:i') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>

    @push('scripts')
    @if(config('midtrans.is_production'))
    <script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    @else
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    @endif
    <script>
        const slotPrice = {{ $slotPrice }};
        
        function decreaseSlot() {
            const input = document.getElementById('slotCount');
            if (input.value > 1) {
                input.value = parseInt(input.value) - 1;
                updateTotal();
            }
        }
        
        function increaseSlot() {
            const input = document.getElementById('slotCount');
            if (input.value < 100) {
                input.value = parseInt(input.value) + 1;
                updateTotal();
            }
        }
        
        function updateTotal() {
            const slots = parseInt(document.getElementById('slotCount').value) || 1;
            const total = slots * slotPrice;
            document.getElementById('totalPrice').textContent = 'Rp ' + total.toLocaleString('id-ID');
        }
        
        function buySlot() {
            const slots = parseInt(document.getElementById('slotCount').value) || 1;
            const button = document.getElementById('buyButton');
            
            button.disabled = true;
            button.innerHTML = '<svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memproses...';
            
            fetch('{{ route("slots.purchase") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ slots: slots })
            })
            .then(response => response.json())
            .then(data => {
                if (data.snap_token) {
                    snap.pay(data.snap_token, {
                        onSuccess: function(result) {
                            window.location.href = '{{ route("slots.success") }}?order_id=' + data.order_id;
                        },
                        onPending: function(result) {
                            window.location.href = '{{ route("slots.index") }}';
                        },
                        onError: function(result) {
                            alert('Pembayaran gagal!');
                            location.reload();
                        },
                        onClose: function() {
                            button.disabled = false;
                            button.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg> Bayar Sekarang';
                        }
                    });
                } else {
                    alert('Gagal membuat transaksi');
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan');
                location.reload();
            });
        }
    </script>
    @endpush
</x-app-layout>

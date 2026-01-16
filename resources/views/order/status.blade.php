<x-layouts.app title="Order Status - {{ $order->order_number }}">
    <div class="py-12 md:py-20">
        <div class="px-4 mx-auto max-w-3xl">
            <!-- Status Card -->
            <div class="relative bg-dark-800 border border-gray-700/50 rounded-2xl overflow-hidden shadow-2xl">
                <!-- Background Glow -->
                <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-1/2 bg-gradient-to-b from-indigo-500/10 to-transparent blur-3xl pointer-events-none"></div>

                <div class="relative p-8 md:p-12">
                     <!-- Order Status Header -->
                     <div class="text-center mb-10">
                        @if($order->status === 'completed' || $order->status === 'success' || $order->transaction_status === 'settlement')
                            <div class="flex items-center justify-center w-24 h-24 mx-auto mb-6 bg-green-500/10 rounded-full ring-4 ring-green-500/20 shadow-[0_0_30px_rgba(34,197,94,0.3)]">
                                <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <h1 class="mb-2 text-3xl font-black text-white tracking-tight">Pembayaran Berhasil!</h1>
                            <p class="text-gray-400">Pesanan Anda sedang diproses dan akan segera dikirim.</p>
                        @elseif($order->status === 'processing')
                            <div class="flex items-center justify-center w-24 h-24 mx-auto mb-6 bg-blue-500/10 rounded-full ring-4 ring-blue-500/20 shadow-[0_0_30px_rgba(59,130,246,0.3)]">
                                <svg class="w-12 h-12 text-blue-500 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                            <h1 class="mb-2 text-3xl font-black text-white tracking-tight">Pesanan Diproses</h1>
                            <p class="text-gray-400">Sistem kami sedang memproses top-up Anda secara otomatis.</p>
                        @elseif($order->status === 'pending')
                            <div class="flex items-center justify-center w-24 h-24 mx-auto mb-6 bg-brand-yellow/10 rounded-full ring-4 ring-brand-yellow/20 shadow-[0_0_30px_rgba(250,204,21,0.3)]">
                                <svg class="w-12 h-12 text-brand-yellow animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h1 class="mb-2 text-3xl font-black text-white tracking-tight">Menunggu Pembayaran</h1>
                            <p class="text-gray-400">Silakan selesaikan pembayaran Anda sebelum kedaluwarsa.</p>
                        @else
                            <div class="flex items-center justify-center w-24 h-24 mx-auto mb-6 bg-red-500/10 rounded-full ring-4 ring-red-500/20 shadow-[0_0_30px_rgba(239,68,68,0.3)]">
                                <svg class="w-12 h-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </div>
                            <h1 class="mb-2 text-3xl font-black text-white tracking-tight">Pembayaran Gagal</h1>
                            <p class="text-gray-400">Maaf, transaksi Anda gagal atau dibatalkan.</p>
                        @endif
                    </div>

                    <!-- Order Details Card -->
                    <div class="bg-dark-900/50 border border-gray-700/50 rounded-2xl p-6 mb-8">
                        <h2 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-6 pb-4 border-b border-gray-700/50">Detail Transaksi</h2>
                        
                        <div class="space-y-4">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-400">Nomer Order</span>
                                <span class="font-mono font-bold text-white bg-dark-800 px-3 py-1 rounded border border-gray-700">{{ $order->order_number }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-400">Game / Produk</span>
                                <span class="font-bold text-white text-right">{{ $order->game->name }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-400">ID Akun</span>
                                <span class="font-bold text-white text-right">{{ $order->game_account_name ?? $order->game_account_id }} <span class="text-gray-500 font-normal">({{ $order->game_account_id }})</span></span>
                            </div>
                            
                            @foreach($order->items as $item)
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-400">Item</span>
                                <span class="font-bold text-brand-yellow text-right">{{ $item->product_name }}</span>
                            </div>
                            @endforeach
                            
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-400">Metode Pembayaran</span>
                                <span class="font-medium text-white text-right">{{ $order->payment_method }}</span>
                            </div>
                            
                            <div class="pt-4 mt-4 border-t border-gray-700/50">
                                <div class="flex justify-between items-center">
                                    <span class="text-base font-bold text-white">Total Pembayaran</span>
                                    <span class="text-2xl font-black text-brand-yellow">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="space-y-4">
                        @if($order->status === 'pending')
                        <button onclick="checkStatus()" id="checkStatusBtn" class="group relative w-full flex justify-center py-4 px-4 border border-transparent text-sm font-black rounded-xl text-black bg-brand-yellow hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-yellow transition-all shadow-[0_0_20px_rgba(255,193,7,0.3)] hover:shadow-[0_0_30px_rgba(255,193,7,0.5)]">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-black group-hover:animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </span>
                            <span id="checkStatusText">Cek Status Pembayaran</span>
                            <span id="checkStatusLoader" class="hidden">Checking...</span>
                        </button>

                        @if(app()->environment('local'))
                        <!-- Simulation Button (Dev Only) -->
                        <button onclick="simulatePayment()" id="simulateBtn" class="w-full py-3 px-4 border border-gray-700 text-sm font-bold rounded-xl text-blue-400 bg-dark-900 hover:bg-dark-800 focus:outline-none transition-all">
                            🧪 Simulasi Bayar Sukses (Dev Mode)
                            <span id="simulateLoader" class="hidden ml-2">...</span>
                        </button>
                        @endif
                        @endif
                        
                        <div class="grid grid-cols-2 gap-4">
                            <a href="{{ route('dashboard') }}" class="flex items-center justify-center px-6 py-3 border border-gray-700 text-base font-bold rounded-xl text-white bg-dark-800 hover:bg-gray-700 transition-all hover:border-gray-500">
                                Riwayat
                            </a>
                            <a href="{{ url('/') }}" class="flex items-center justify-center px-6 py-3 border border-gray-700 text-base font-bold rounded-xl text-white bg-dark-800 hover:bg-gray-700 transition-all hover:border-gray-500">
                                Beranda
                            </a>
                        </div>
                        
                        @if($order->status === 'pending')
                        <p class="text-xs text-center text-gray-500 mt-4">
                            Halaman ini akan refresh otomatis setiap 30 detik untuk mengecek pembayaran.
                        </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Auto refresh for pending orders
        @if($order->status === 'pending')
        let autoRefreshInterval = setInterval(() => {
            console.log('Auto-checking order status...');
            checkStatus(true); 
        }, 30000); 
        @endif
        
        function checkStatus(isAuto = false) {
            const btn = document.getElementById('checkStatusBtn');
            const text = document.getElementById('checkStatusText');
            const loader = document.getElementById('checkStatusLoader');
            
            if (!isAuto && btn) {
                btn.disabled = true;
                text.classList.add('hidden');
                loader.classList.remove('hidden');
            }
            
            fetch('{{ route("order.checkStatus", $order->order_number) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.old_status !== data.new_status || data.transaction_status === 'settlement' || data.transaction_status === 'capture') {
                        location.reload();
                    } else {
                        if (!isAuto && btn) {
                            btn.disabled = false;
                            text.classList.remove('hidden');
                            loader.classList.add('hidden');
                            
                            let message = data.user_message || 'Status: ' + (data.transaction_status || 'Pending');
                            // alert(message); // Optional: Don't annoy user with alerts on manual check if nothing changed
                        }
                    }
                } else {
                    if (!isAuto && btn) {
                        btn.disabled = false;
                        text.classList.remove('hidden');
                        loader.classList.add('hidden');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (!isAuto && btn) {
                    btn.disabled = false;
                    text.classList.remove('hidden');
                    loader.classList.add('hidden');
                }
            });
        }
        
        window.addEventListener('beforeunload', () => {
            @if($order->status === 'pending')
            clearInterval(autoRefreshInterval);
            @endif
        });

        function simulatePayment() {
            if(!confirm('Simulasi pembayaran sukses? Status order akan berubah.')) return;

            const btn = document.getElementById('simulateBtn');
            
            if(btn) btn.disabled = true;
            
            fetch('{{ route("order.simulatePayment", $order->order_number) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                    if(btn) btn.disabled = false;
                }
            })
            .catch(e => {
                alert('System error');
                if(btn) btn.disabled = false;
            });
        }
    </script>
</x-layouts.app>

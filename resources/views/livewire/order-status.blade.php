<div wire:poll.5s="checkStatus" class="max-w-3xl mx-auto">
    <div class="overflow-hidden bg-gray-800 border border-gray-700 shadow-2xl rounded-2xl">
        <div class="p-8 text-center border-b border-gray-700">
            @if($order->status === 'pending')
                <div class="inline-flex items-center justify-center w-16 h-16 mb-4 bg-yellow-900/50 rounded-full">
                    <svg class="w-8 h-8 text-yellow-500 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-white">Menunggu Pembayaran</h2>
                <p class="mt-2 text-gray-400">Selesaikan pembayaran sebelum waktu habis</p>
            @elseif($order->status === 'processing')
                <div class="inline-flex items-center justify-center w-16 h-16 mb-4 bg-blue-900/50 rounded-full">
                    <svg class="w-8 h-8 text-blue-500 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-white">Sedang Diproses</h2>
                <p class="mt-2 text-gray-400">Pesanan Anda sedang diproses sistem</p>
            @elseif($order->status === 'completed')
                <div class="inline-flex items-center justify-center w-16 h-16 mb-4 bg-green-900/50 rounded-full">
                    <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-white">Transaksi Berhasil</h2>
                <p class="mt-2 text-gray-400">Top up telah masuk ke akun Anda</p>
            @elseif($order->status === 'failed')
                <div class="inline-flex items-center justify-center w-16 h-16 mb-4 bg-red-900/50 rounded-full">
                    <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-white">Transaksi Gagal</h2>
                <p class="mt-2 text-gray-400">Silakan hubungi customer service</p>
            @endif
        </div>
        
        @if($order->status === 'pending')
        <div class="px-8 pb-4 text-center">
            <button onclick="window.location.reload()" class="px-6 py-2 bg-brand-yellow text-black font-bold rounded-xl hover:bg-yellow-400 transition-colors">
                Cek Status / Bayar Ulang
            </button>
            <p class="text-xs text-gray-500 mt-2">Jika popup pembayaran tertutup, silakan order ulang atau hubungi admin.</p>
        </div>
        @endif

        <div class="p-8 space-y-6">
            <div class="flex justify-between pb-4 border-b border-gray-700">
                <span class="text-gray-400">Nomor Order</span>
                <span class="font-mono font-medium text-white">{{ $order->order_number }}</span>
            </div>
            <div class="flex justify-between pb-4 border-b border-gray-700">
                <span class="text-gray-400">Game</span>
                <span class="font-medium text-white">{{ $order->game->name }}</span>
            </div>
            <div class="flex justify-between pb-4 border-b border-gray-700">
                <span class="text-gray-400">Item</span>
                <span class="font-medium text-white">{{ $order->items->first()->product_name }}</span>
            </div>
            <div class="flex justify-between pb-4 border-b border-gray-700">
                <span class="text-gray-400">User ID</span>
                <span class="font-medium text-white">{{ $order->game_account_id }}</span>
            </div>
            <div class="flex justify-between pt-2">
                <span class="text-lg font-bold text-white">Total Pembayaran</span>
                <span class="text-lg font-bold text-indigo-400">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>
</div>

<div class="py-12 bg-dark-900 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-10">
            <h1 class="text-3xl font-extrabold text-white italic">CEK <span class="text-brand-yellow">TRANSAKSI</span></h1>
            <p class="mt-2 text-gray-400">Lacak status pesanan Anda dengan mudah</p>
        </div>

        <!-- Search Box -->
        <div class="bg-dark-800 rounded-2xl p-6 md:p-8 border border-gray-700/50 shadow-xl mb-8">
            <form wire:submit.prevent="findTransaction" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <label for="search" class="sr-only">Nomor Invoice / No. HP</label>
                    <input type="text" 
                        wire:model="search"
                        class="w-full bg-dark-900 border border-gray-700 text-white rounded-xl px-5 py-4 focus:ring-2 focus:ring-brand-yellow focus:border-transparent placeholder-gray-500 transition-all font-medium"
                        placeholder="Masukkan Nomor Invoice atau Nomor HP...">
                    @error('search') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>
                <button type="submit" 
                    wire:loading.attr="disabled"
                    class="bg-brand-yellow text-black font-bold px-8 py-4 rounded-xl hover:bg-yellow-400 transition-colors flex items-center justify-center gap-2 min-w-[160px]">
                    <span wire:loading.remove>Cari Pesanan</span>
                    <span wire:loading>
                        <svg class="animate-spin h-5 w-5 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </span>
                </button>
            </form>
        </div>

        <!-- Result -->
        @if($hasSearched)
            <div class="space-y-4">
                <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                    <span class="w-1 h-6 bg-brand-yellow rounded-full"></span>
                    Hasil Pencarian
                </h3>
                
                @forelse($orders as $order)
                    <div class="bg-dark-800 rounded-xl p-6 border border-gray-700/50 hover:border-brand-yellow/50 transition-colors shadow-lg">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                            <!-- Left: Info -->
                            <div>
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="text-sm font-mono bg-dark-900 text-gray-300 px-2 py-1 rounded border border-gray-700">{{ $order->invoice }}</span>
                                    <span class="text-xs text-gray-500">{{ $order->created_at->format('d M Y H:i') }}</span>
                                </div>
                                <h4 class="text-lg font-bold text-white mb-1">
                                    {{ $order->items->first()->product_name ?? 'Item Produk' }}
                                </h4>
                                <p class="text-sm text-gray-400">Total: <span class="text-brand-yellow font-bold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span></p>
                            </div>

                            <!-- Right: Status -->
                            <div>
                                @if($order->status == 'pending')
                                    <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-bold bg-yellow-500/10 text-yellow-500 border border-yellow-500/20">
                                        <div class="w-2 h-2 rounded-full bg-yellow-500 mr-2 animate-pulse"></div>
                                        PENDING
                                    </span>
                                @elseif($order->status == 'processing')
                                    <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-bold bg-blue-500/10 text-blue-500 border border-blue-500/20">
                                        <div class="w-2 h-2 rounded-full bg-blue-500 mr-2 animate-bounce"></div>
                                        PROSES
                                    </span>
                                @elseif($order->status == 'completed' || $order->status == 'success')
                                    <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-bold bg-green-500/10 text-green-500 border border-green-500/20">
                                        <div class="w-2 h-2 rounded-full bg-green-500 mr-2"></div>
                                        SUKSES
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-bold bg-red-500/10 text-red-500 border border-red-500/20">
                                        <div class="w-2 h-2 rounded-full bg-red-500 mr-2"></div>
                                        {{ strtoupper($order->status) }}
                                    </span>
                                @endif
                                
                                @if($order->status == 'pending')
                                    <div class="mt-2 text-right">
                                        <button wire:click="$dispatch('open-modal', 'payment-modal-{{ $order->id }}')" class="text-xs text-brand-yellow hover:text-white underline">
                                            Lanjutkan Pembayaran
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 bg-dark-800 rounded-xl border border-gray-700/50 border-dashed">
                        <div class="bg-dark-900 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-1">Tidak Ditemukan</h3>
                        <p class="text-gray-400 text-sm">Transaksi tidak ditemukan dengan data tersebut.</p>
                    </div>
                @endforelse
            </div>
        @endif
    </div>
</div>

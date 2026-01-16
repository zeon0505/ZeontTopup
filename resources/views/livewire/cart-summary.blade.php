<div class="space-y-4">
    <div class="bg-dark-800 rounded-2xl p-6 border border-gray-700/50">
        <h3 class="text-white font-bold text-lg mb-4">Detail Pesanan</h3>
        
        <!-- Voucher Code Input -->
        <div class="mb-4">
             <label class="text-gray-400 text-sm mb-1 block">Kode Voucher</label>
             <div class="flex gap-2">
                 <div class="relative flex-1">
                     <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                     </span>
                     <input 
                         type="text" 
                         wire:model="voucherCode" 
                         @if($appliedVoucher) disabled @endif
                         class="w-full bg-dark-900 border {{ $appliedVoucher ? 'border-green-500 text-green-500' : 'border-gray-700 text-white' }} rounded-lg pl-9 pr-3 py-2 text-sm focus:ring-1 focus:ring-brand-yellow focus:border-brand-yellow placeholder-gray-600 uppercase transition-colors" 
                         placeholder="Masukan Kode"
                     >
                 </div>
                 @if($appliedVoucher)
                     <button wire:click="removeVoucher" class="px-3 py-2 bg-red-500/10 text-red-500 border border-red-500/20 rounded-lg hover:bg-red-500/20 transition-colors">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                     </button>
                 @else
                     <button wire:click="applyVoucher" class="px-3 py-2 bg-dark-700 text-gray-300 border border-gray-600 rounded-lg hover:bg-dark-600 hover:text-white transition-colors text-sm font-medium">
                         Pakai
                     </button>
                 @endif
             </div>
             @error('voucherCode') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
             @if($appliedVoucher)
                 <div class="text-green-500 text-xs mt-1 flex items-center gap-1">
                     <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                     Voucher Applied: {{ $appliedVoucher->code }}
                 </div>
             @endif
        </div>

        <!-- Loyalty Points Toggle -->
        @auth
            @if(auth()->user()->points > 0)
                <div class="mb-4 p-3 bg-indigo-500/10 border border-indigo-500/20 rounded-xl flex items-center justify-between group cursor-pointer hover:bg-indigo-500/20 transition-all" wire:click="togglePoints">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-indigo-600 flex items-center justify-center text-white shadow-[0_0_10px_rgba(79,70,229,0.5)]">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Tukarkan Poin</p>
                            <p class="text-white font-black italic">{{ number_format(auth()->user()->points) }} <span class="text-[10px] text-indigo-400 uppercase font-normal">Poin Tersedia</span></p>
                        </div>
                    </div>
                    <div class="relative inline-flex items-center cursor-pointer">
                        <div class="w-11 h-6 bg-dark-900 border border-gray-700 rounded-full transition-colors {{ $usePoints ? 'bg-indigo-600 border-indigo-500' : '' }}"></div>
                        <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-transform {{ $usePoints ? 'translate-x-5' : '' }}"></div>
                    </div>
                </div>
            @endif
        @endauth

        Order Details
        <div class="space-y-3 mb-6 bg-dark-900/50 p-4 rounded-xl border border-dashed border-gray-700">
            <div class="flex justify-between text-sm">
                <span class="text-gray-400">Item:</span>
                <span class="text-white font-medium text-right">{{ $product['name'] ?? '-' }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-400">Harga:</span>
                <span class="text-white font-medium">Rp {{ number_format($product['price'] ?? 0, 0, ',', '.') }}</span>
            </div>
            @if(isset($paymentMethod['fee']) && $paymentMethod['fee'] > 0)
                <div class="flex justify-between text-sm">
                    <span class="text-gray-400">Fee Transaksi:</span>
                    <span class="text-white font-medium">Rp {{ number_format($paymentMethod['fee'], 0, ',', '.') }}</span>
                </div>
            @endif
             @if($discountAmount > 0)
                <div class="flex justify-between text-sm items-center">
                    <span class="text-green-500 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                        Diskon Voucher:
                    </span>
                    <span class="text-green-500 font-bold">-Rp {{ number_format($discountAmount, 0, ',', '.') }}</span>
                </div>
            @endif
            @if($pointsDiscount > 0)
                <div class="flex justify-between text-sm items-center">
                    <span class="text-indigo-400 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        Diskon Poin:
                    </span>
                    <span class="text-indigo-400 font-bold">-Rp {{ number_format($pointsDiscount, 0, ',', '.') }}</span>
                </div>
            @endif
            <div class="pt-3 border-t border-gray-700 flex justify-between items-center">
                <span class="text-white font-bold">Total:</span>
                <span class="text-xl font-black text-brand-yellow">
                    Rp {{ number_format($total, 0, ',', '.') }}
                </span>
            </div>
        </div>

        <!-- Auto Top-Up Toggle -->
        @auth
            @if(isset($paymentMethod['code']) && strtoupper($paymentMethod['code']) === 'SALDO')
                <div class="mb-4 p-4 bg-brand-yellow/5 border border-brand-yellow/20 rounded-2xl">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-brand-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="text-white font-bold text-sm italic">Auto Top-Up 🤖</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model.live="isScheduled" class="sr-only peer">
                            <div class="w-11 h-6 bg-dark-900 border border-gray-700 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-gray-400 after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-yellow peer-checked:after:bg-black"></div>
                        </label>
                    </div>
                    
                    @if($isScheduled)
                        <div class="space-y-3 animate-in fade-in slide-in-from-top-2 duration-300">
                            <p class="text-[10px] text-gray-400 leading-relaxed italic">Jadwalkan top up otomatis untuk produk ini. Sistem akan memotong saldo Anda secara otomatis sesuai jadwal.</p>
                            <div class="grid grid-cols-2 gap-2">
                                <button type="button" wire:click="$set('frequency', 'weekly')" class="py-2 px-3 rounded-xl border {{ $frequency === 'weekly' ? 'bg-brand-yellow text-black border-brand-yellow' : 'bg-dark-900 text-gray-400 border-gray-700' }} text-xs font-bold transition-all">Mingguan</button>
                                <button type="button" wire:click="$set('frequency', 'monthly')" class="py-2 px-3 rounded-xl border {{ $frequency === 'monthly' ? 'bg-brand-yellow text-black border-brand-yellow' : 'bg-dark-900 text-gray-400 border-gray-700' }} text-xs font-bold transition-all">Bulanan</button>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        @endauth

        <!-- Action Button -->
        <button
            wire:click="checkout"
            wire:loading.attr="disabled"
            class="w-full py-3.5 bg-brand-yellow text-black font-black text-lg rounded-xl hover:bg-yellow-400 transition-all shadow-[0_4px_14px_0_rgba(255,193,7,0.39)] disabled:opacity-50 disabled:cursor-not-allowed disabled:shadow-none flex items-center justify-center gap-2 group"
            @if(!$this->canCheckout()) disabled @endif
        >
            <span wire:loading.remove>Beli Sekarang</span>
            <span wire:loading class="flex items-center">
                <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Processing...
            </span>
            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
            </svg>
        </button>
    </div>

</div>

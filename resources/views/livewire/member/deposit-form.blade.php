<div class="min-h-screen py-12 bg-dark-900">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8 text-center" x-data="{ }">
            <h1 class="text-3xl font-black text-white italic tracking-wider">TOP UP SALDO 💰</h1>
            <p class="text-gray-400 mt-2">Isi saldo akunmu untuk pembayaran instan dan mudah.</p>
            
            @if(session()->has('error'))
                <div class="mt-4 p-4 bg-red-500/10 border border-red-500/20 rounded-xl text-red-500 text-sm animate-pulse">
                    {{ session('error') }}
                </div>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Left: Form -->
            <div class="md:col-span-2 space-y-6">
                
                <!-- Amount Selection -->
                <div class="bg-dark-800 rounded-2xl p-6 border border-gray-700/50">
                    <h3 class="text-white font-bold text-lg mb-4 flex items-center gap-2">
                        <span class="bg-brand-yellow text-black text-xs px-2 py-1 rounded-full font-black">1</span>
                        Pilih Nominal Deposit
                    </h3>
                    
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mb-4">
                        @foreach([10000, 20000, 50000, 100000, 200000, 500000] as $preset)
                            <button 
                                wire:click="setAmount({{ $preset }})"
                                class="p-3 rounded-xl border transition-all text-left group
                                {{ $amount == $preset 
                                    ? 'bg-brand-yellow border-brand-yellow text-black shadow-[0_0_15px_rgba(255,193,7,0.4)]' 
                                    : 'bg-dark-900 border-gray-700 hover:border-gray-500 hover:bg-dark-700' 
                                }}"
                            >
                                <span class="block text-sm font-medium {{ $amount == $preset ? 'text-black' : 'text-gray-400 group-hover:text-gray-300' }}">Nominal</span>
                                <span class="block text-lg font-bold {{ $amount == $preset ? 'text-black' : 'text-white' }}">
                                    Rp {{ number_format($preset, 0, ',', '.') }}
                                </span>
                            </button>
                        @endforeach
                    </div>

                    <!-- Custom Amount -->
                    <div>
                        <label class="text-gray-400 text-sm mb-1 block">Nominal Lainnya</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 font-bold">Rp</span>
                            <input 
                                type="number" 
                                wire:model.live="amount" 
                                class="w-full bg-dark-900 border border-gray-700 rounded-xl pl-10 pr-4 py-3 text-white font-bold focus:ring-2 focus:ring-brand-yellow focus:border-transparent placeholder-gray-600"
                                placeholder="Minimal 10.000"
                            >
                        </div>
                        @error('amount') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Payment Method -->
                 <div class="bg-dark-800 rounded-2xl p-6 border border-gray-700/50">
                    <h3 class="text-white font-bold text-lg mb-4 flex items-center gap-2">
                        <span class="bg-brand-yellow text-black text-xs px-2 py-1 rounded-full font-black">2</span>
                        Pilih Pembayaran
                    </h3>
                    
                    <div class="space-y-3">
                         @foreach($paymentMethods as $method)
                            <button 
                                wire:click="selectPaymentMethod('{{ $method->id }}')"
                                class="w-full p-4 rounded-xl border transition-all flex items-center justify-between group
                                {{ $paymentMethodId === $method->id 
                                    ? 'bg-dark-900 border-brand-yellow ring-1 ring-brand-yellow shadow-[0_0_15px_rgba(255,193,7,0.2)]' 
                                    : 'bg-dark-900 border-gray-700 hover:border-gray-500 hover:bg-dark-700' 
                                }}"
                            >
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-8 bg-white rounded flex items-center justify-center p-1">
                                        @if($method->logo)
                                            <img src="{{ Storage::url($method->logo) }}" class="max-h-full max-w-full">
                                        @else
                                            <span class="text-xs font-bold text-black">{{ $method->code }}</span>
                                        @endif
                                    </div>
                                    <div class="text-left">
                                        <div class="text-white font-bold text-sm">{{ $method->name }}</div>
                                        <div class="text-xs text-gray-400">Proses Otomatis</div>
                                    </div>
                                </div>
                                
                                @if($paymentMethodId === $method->id)
                                    <div class="w-5 h-5 bg-brand-yellow rounded-full flex items-center justify-center">
                                        <svg class="w-3 h-3 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                @endif
                            </button>
                        @endforeach
                    </div>
                    @error('paymentMethodId') <span class="text-red-500 text-sm mt-1 block selection:bg-red-500 selection:text-white">Silakan pilih metode pembayaran</span> @enderror
                </div>

            </div>

            <!-- Right: Summary -->
            <div class="col-span-1">
                <div class="bg-dark-800 rounded-2xl p-6 border border-gray-700/50 sticky top-24">
                    <h3 class="text-white font-bold text-lg mb-4">Rincian Deposit</h3>
                    
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-400">Nominal:</span>
                            <span class="text-white font-bold">Rp {{ number_format((int)$amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-400">Biaya Admin:</span>
                            <span class="text-white">Gratis</span>
                        </div>
                        <div class="pt-3 border-t border-gray-700 flex justify-between items-center">
                            <span class="text-white font-bold">Total Bayar:</span>
                            <span class="text-xl font-black text-brand-yellow">
                                Rp {{ number_format((int)$amount, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <button 
                        wire:click="processDeposit"
                        wire:loading.attr="disabled"
                        class="w-full py-3.5 bg-brand-yellow text-black font-black text-lg rounded-xl hover:bg-yellow-400 transition-all shadow-[0_4px_14px_0_rgba(255,193,7,0.39)] flex items-center justify-center gap-2 group disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        <span wire:loading.remove>Deposit Sekarang</span>
                        <span wire:loading>Processing...</span>
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>

                    <p class="text-xs text-gray-500 mt-4 text-center">
                        Dengan melanjutkan, Anda menyetujui Syarat & Ketentuan layanan kami.
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Midtrans Script -->
    <script src="{{ config('services.midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
             const handleDeposit = (data) => {
                const { snap_token, deposit_number } = data;
                if (!snap_token) return;
                
                console.log('Triggering Snap for deposit:', deposit_number);
                
                snap.pay(snap_token, {
                    onSuccess: function(result) { window.location.href = "{{ route('dashboard') }}"; },
                    onPending: function(result) { window.location.href = "{{ route('dashboard') }}"; },
                    onError: function(result) { alert('Payment failed!'); }
                });
            };

            Livewire.on('deposit-initiated', (event) => {
                console.log('Livewire event received:', event);
                const data = Array.isArray(event) ? event[0] : event;
                handleDeposit(data);
            });

            window.addEventListener('deposit-initiated', (event) => {
                console.log('Window event received:', event.detail);
                handleDeposit(event.detail);
            });
        });
    </script>
</div>

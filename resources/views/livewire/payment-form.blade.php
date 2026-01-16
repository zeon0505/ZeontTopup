<div class="bg-dark-800 rounded-2xl border border-gray-700/50 overflow-hidden">
    <!-- Header -->
    <div class="p-4 md:p-6 bg-dark-900/50 border-b border-gray-700/50 flex items-center gap-4">
        <div class="w-8 h-8 md:w-10 md:h-10 rounded-full bg-brand-yellow flex items-center justify-center font-black text-black text-lg shadow-[0_0_15px_rgba(255,193,7,0.4)]">
            3
        </div>
        <h2 class="text-lg md:text-xl font-bold text-white">Pilih Pembayaran</h2>
    </div>

    <!-- Content -->
    <div class="p-6 md:p-8 space-y-8">
        @foreach($paymentMethods as $category => $methods)
            <div class="space-y-4">
                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider pl-1 border-l-4 border-brand-yellow">{{ $category }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($methods as $method)
                        <button
                            wire:click="selectMethod('{{ $method['code'] }}', '{{ $category }}')"
                            class="group relative flex items-center p-4 rounded-xl border transition-all duration-200 text-left
                            {{ $selectedMethodCode === $method['code'] 
                                ? 'bg-dark-900 border-brand-yellow shadow-[0_0_15px_rgba(255,193,7,0.15)] ring-1 ring-brand-yellow' 
                                : 'bg-dark-900 border-gray-700 hover:border-gray-500 hover:bg-dark-800' 
                            }}"
                        >
                            <!-- Logo Wrapper -->
                            <div class="w-16 h-10 flex-shrink-0 bg-white rounded flex items-center justify-center mr-4 overflow-hidden p-1">
                                @if(isset($method['icon']) && $method['icon'])
                                    <img src="{{ asset($method['icon']) }}" alt="{{ $method['name'] }}" class="h-full object-contain">
                                @else
                                    <span class="text-[10px] font-bold text-gray-800 uppercase text-center leading-tight">
                                        {{ substr($method['name'], 0, 8) }}
                                    </span>
                                @endif
                            </div>

                            <!-- Name & Price (if applicable) -->
                            <div class="flex-1">
                                <span class="block text-sm font-bold text-white group-hover:text-brand-yellow transition-colors">
                                    {{ $method['name'] }}
                                </span>
                                @if(isset($method['fee']) && $method['fee'] > 0)
                                    <span class="text-xs text-gray-400">+ Fee Rp {{ number_format($method['fee'], 0, ',', '.') }}</span>
                                @endif
                            </div>

                            <!-- Checkmark -->
                            @if($selectedMethodCode === $method['code'])
                                <div class="absolute top-2 right-2 flex text-brand-yellow">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            @endif
                        </button>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>

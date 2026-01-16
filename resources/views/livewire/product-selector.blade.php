<div class="bg-dark-800 rounded-2xl border border-gray-700/50 overflow-hidden">
    <!-- Header -->
    <div class="p-4 md:p-6 bg-dark-900/50 border-b border-gray-700/50 flex items-center gap-4">
        <div class="w-8 h-8 md:w-10 md:h-10 rounded-full bg-brand-yellow flex items-center justify-center font-black text-black text-lg shadow-[0_0_15px_rgba(255,193,7,0.4)]">
            2
        </div>
        <h2 class="text-lg md:text-xl font-bold text-white">Pilih Nominal Top Up</h2>
    </div>

    <!-- Content -->
    <div class="p-6 md:p-8">
        <!-- Flash Sale Section -->
        @if($flashSaleProducts->count() > 0)
            <div class="flex items-center gap-2 mb-4 text-brand-yellow">
                <div class="p-1 rounded bg-brand-yellow/10 animate-pulse">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <span class="font-black italic uppercase tracking-wider text-xl">Flash Sale ⚡</span>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-8">
                @foreach($flashSaleProducts as $product)
                    <button
                        wire:key="fs-{{ $product->id }}"
                        type="button"
                        wire:click="selectProduct('{{ $product->id }}')"
                        class="group relative overflow-hidden rounded-xl border transition-all duration-300 text-left cursor-pointer
                        {{ $selectedProductId === $product->id 
                            ? 'bg-dark-900 border-red-500 shadow-[0_0_20px_rgba(220,38,38,0.3)] ring-1 ring-red-500' 
                            : 'bg-dark-900 border-red-900/30 hover:border-red-500 hover:bg-dark-800' 
                        }}"
                    >
                         <!-- Flash Sale Badge -->
                         <div class="absolute top-0 right-0 bg-red-600 text-white text-[10px] font-bold px-2 py-1 rounded-bl-lg z-10 animate-pulse pointer-events-none">
                            FLASHSALE
                        </div>

                        <!-- Gradient Background Effect -->
                        <div class="absolute inset-0 bg-gradient-to-br from-red-500/5 via-transparent to-transparent opacity-50 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
                        
                        <div class="relative p-4 flex flex-col h-full min-h-[120px] justify-between">
                            <!-- Top: Item Name -->
                            <div class="pr-6"> <!-- Padding right for badge -->
                                <span class="text-sm font-bold text-white group-hover:text-red-400 transition-colors line-clamp-2">
                                    {{ $product->name }}
                                </span>
                            </div>

                            <!-- Icon -->
                            <div class="flex justify-end my-2">
                                <svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2L2 12l10 10 10-10L12 2zm0 2.8l7.2 7.2-7.2 7.2-7.2-7.2 7.2-7.2z"/>
                                </svg>
                            </div>
                            
                            <!-- Bottom: Price -->
                            <div class="mt-auto">
                                <div class="text-[10px] text-gray-500 line-through mb-0.5">
                                    Rp {{ number_format($product->getRawOriginal('price'), 0, ',', '.') }}
                                </div>
                                <div class="text-red-500 font-black text-lg">
                                    Rp {{ number_format($product->activeFlashSale->discount_price, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>

                        <!-- Selected Indicator Checkmark -->
                        @if($selectedProductId === $product->id)
                            <div class="absolute top-0 left-0 bg-red-600 w-8 h-8 flex items-center justify-center rounded-br-xl shadow-lg z-20">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                        @endif
                    </button>
                @endforeach
            </div>
        @endif

        <!-- Regular Products Section -->
        <div class="flex items-center gap-2 mb-4 text-white">
            <div class="p-1 rounded bg-gray-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <span class="font-bold uppercase tracking-wider text-lg">Top Up Regular</span>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($normalProducts as $product)
                <button
                    wire:key="reg-{{ $product->id }}"
                    type="button"
                    wire:click="selectProduct('{{ $product->id }}')"
                    class="group relative overflow-hidden rounded-xl border transition-all duration-300 text-left
                    {{ $selectedProductId === $product->id 
                        ? 'bg-dark-900 border-brand-yellow shadow-[0_0_20px_rgba(255,193,7,0.15)] ring-1 ring-brand-yellow' 
                        : 'bg-dark-900 border-gray-700 hover:border-gray-500 hover:bg-dark-800' 
                    }}"
                >
                    <!-- Gradient Background Effect -->
                    <div class="absolute inset-0 bg-gradient-to-br from-transparent via-transparent to-white/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    
                    <div class="relative p-4 flex flex-col h-full min-h-[120px] justify-between">
                        <!-- Top: Item Name -->
                        <div class="flex justify-between items-start w-full">
                            <span class="text-sm font-bold text-white group-hover:text-brand-yellow transition-colors line-clamp-2">
                                {{ $product->name }}
                            </span>
                            @if($product->original_price > $product->price)
                                <span class="bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded ml-2 flex-shrink-0">
                                    PROMO
                                </span>
                            @endif
                        </div>

                        <!-- Icon -->
                        <div class="flex justify-end my-2">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2L2 12l10 10 10-10L12 2zm0 2.8l7.2 7.2-7.2 7.2-7.2-7.2 7.2-7.2z"/>
                            </svg>
                        </div>
                        
                        <!-- Bottom: Price -->
                        <div class="mt-4">
                            @if($product->original_price > $product->price)
                                <div class="text-[10px] text-gray-500 line-through mb-0.5">
                                    Rp {{ number_format($product->original_price, 0, ',', '.') }}
                                </div>
                            @endif
                            <div class="text-brand-yellow font-black text-lg">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>

                    <!-- Selected Indicator Checkmark -->
                    @if($selectedProductId === $product->id)
                        <div class="absolute top-0 right-0 bg-brand-yellow w-8 h-8 flex items-center justify-center rounded-bl-xl shadow-lg">
                            <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                    @endif
                </button>
            @endforeach
        </div>
    </div>
</div>

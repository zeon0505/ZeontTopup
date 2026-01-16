<div class="py-12 bg-slate-900">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <!-- Header & Filters -->
        <div class="mb-10">
            <div class="flex items-center gap-3 mb-6">
                <div class="p-2 rounded-lg bg-red-500/10">
                    <svg class="w-8 h-8 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                        <path d="M11 7h2v5.42l3.71 3.71-1.42 1.42L11 12.8V7z" opacity=".3"/> <!-- Placeholder fire icon logic, using standard shapes for now -->
                        <path d="M13.5.67s.74 2.65.74 4.8c0 2.06-1.35 3.73-3.41 3.73-2.07 0-3.63-1.67-3.63-3.73l.03-.36C5.21 7.51 4 10.62 4 14c0 4.42 3.58 8 8 8s8-3.58 8-8C20 8.61 17.41 3.8 13.5.67zM11.71 19c-1.78 0-3.22-1.4-3.22-3.14 0-1.62 1.05-2.76 2.81-3.12 1.77-.36 3.6-1.21 4.62-2.58.39 1.29.59 2.65.59 4.04 0 2.65-2.15 4.8-4.8 4.8z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-3xl font-black italic text-white uppercase tracking-wider">
                        POPULER <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-yellow to-orange-500">SEKARANG!</span>
                    </h2>
                    <p class="text-gray-400 text-sm">Berikut adalah beberapa produk yang paling populer saat ini.</p>
                </div>
            </div>

            <!-- Filter Buttons -->
            <div class="flex flex-wrap gap-4">
                @foreach($categories as $category)
                    <button 
                        wire:click="setCategory('{{ $category }}')"
                        class="px-6 py-3 rounded-xl text-sm font-bold transition-all duration-300 {{ $activeCategory === $category ? 'bg-brand-yellow text-black shadow-[0_0_15px_rgba(250,204,21,0.3)] scale-105' : 'bg-slate-800 text-gray-400 hover:bg-slate-700 hover:text-white' }}"
                    >
                        {{ $category }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Game Grid -->
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6">
            @forelse($games as $game)
            <a href="{{ route('order.show', $game->slug) }}" 
               data-aos="fade-up"
               class="group relative block overflow-hidden rounded-2xl bg-slate-800 border border-white/5 hover:border-brand-yellow/50 transition-all duration-300 hover:shadow-2xl hover:shadow-brand-yellow/10">
                
                <!-- Image Container -->
                <div class="aspect-[3/4] w-full overflow-hidden relative">
                    <div class="absolute inset-0 bg-slate-900 animate-pulse" wire:loading.class="block" wire:target="setCategory" style="display: none;"></div>
                    
                    @if($game->image)
                        <img src="{{ Storage::url($game->image) }}" 
                             alt="{{ $game->name }}" 
                             class="object-cover w-full h-full transition-transform duration-500 group-hover:scale-110">
                    @else
                        <div class="flex items-center justify-center w-full h-full bg-slate-800">
                            <span class="text-4xl font-black text-gray-700">{{ substr($game->name, 0, 1) }}</span>
                        </div>
                    @endif
                    
                    <!-- Heart Favorite Button -->
                    <div class="absolute top-2 left-2 z-10">
                        <livewire:favorite-button :gameId="$game->id" :key="'fav-home-'.$game->id" />
                    </div>

                    <!-- Hover Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent opacity-60 group-hover:opacity-80 transition-opacity"></div>
                    
                    <!-- Publisher Badge (if exists) or generic tag -->
                     <div class="absolute top-2 right-2">
                        <span class="px-2 py-1 text-[10px] font-bold text-white bg-black/50 backdrop-blur-md rounded-lg border border-white/10">
                            {{ $game->category ?? 'Game' }}
                        </span>
                    </div>
                </div>

                <!-- Content -->
                <div class="absolute bottom-0 inset-x-0 p-4 bg-gradient-to-t from-slate-900 to-transparent pt-12">
                     <h3 class="text-white font-bold text-base leading-tight group-hover:text-brand-yellow transition-colors line-clamp-2">
                        {{ $game->name }}
                    </h3>
                    <p class="text-xs text-gray-400 mt-1 truncate">{{ $game->publisher ?? 'Official' }}</p>
                    
                    <!-- Rating Stars -->
                    @if($game->reviews_count > 0)
                        <div class="flex items-center gap-1 mt-2">
                            <div class="flex">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-3 h-3 {{ $i <= round($game->average_rating) ? 'text-yellow-400' : 'text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                            <span class="text-xs text-gray-400">{{ number_format($game->average_rating, 1) }} ({{ $game->reviews_count }})</span>
                        </div>
                    @endif
                </div>
            </a>
            @empty
                <div class="col-span-full py-12 text-center bg-slate-800/50 rounded-2xl border border-dashed border-gray-700">
                    <svg class="w-12 h-12 mx-auto text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                    </svg>
                    <p class="text-gray-400 font-medium">Belum ada games di kategori ini.</p>
                </div>
            @endforelse
        </div>
        
        <!-- View All Link (Optional) -->
        <div class="mt-8 text-center">
             <a href="{{ route('games.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-brand-yellow hover:text-white transition-colors">
                Lihat Semua Produk
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </div>
</div>

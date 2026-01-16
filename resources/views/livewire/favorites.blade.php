<div>
    <!-- Header -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-black text-white">My Favorites</h1>
                <p class="mt-1 text-sm text-gray-400">Games you love ❤️</p>
            </div>
            <a href="{{ route('games.index') }}" wire:navigate class="px-4 py-2 text-sm font-bold text-white bg-brand-yellow rounded-xl hover:bg-yellow-400 transition-all">
                Browse Games
            </a>
        </div>

        @if($favorites->isEmpty())
            <!-- Empty State -->
            <div class="flex flex-col items-center justify-center py-20">
                <div class="p-4 bg-gray-800 rounded-full mb-6">
                    <svg class="w-16 h-16 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-300 mb-2">No Favorites Yet</h3>
                <p class="text-gray-500 mb-6">Start adding games to your favorites!</p>
                <a href="{{ route('games.index') }}" wire:navigate class="px-6 py-3 text-sm font-bold text-black bg-brand-yellow rounded-xl hover:bg-yellow-400 transition-all">
                    Explore Games
                </a>
            </div>
        @else
            <!-- Favorites Grid -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($favorites as $game)
                    <div class="group relative bg-dark-800 rounded-2xl overflow-hidden border border-gray-700/50 hover:border-brand-yellow/50 transition-all duration-300 hover:scale-105" wire:key="fav-{{ $game->id }}">
                        <!-- Image -->
                        <div class="aspect-square relative overflow-hidden">
                            <img src="{{ Storage::url($game->image) }}" alt="{{ $game->name }}" class="w-full h-full object-cover">
                            
                            <!-- Flash Sale Badge -->
                            @if($game->activeFlashSale)
                                <div class="absolute top-2 left-2 px-2 py-1 bg-red-600 text-white text-xs font-bold rounded-lg flex items-center gap-1 animate-pulse">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1h4v1a2 2 0 11-4 0zM12 14c.015-.34.208-.646.477-.859a4 4 0 10-4.954 0c.27.213.462.519.476.859h4.002z"/>
                                    </svg>
                                    FLASH SALE
                                </div>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="p-4">
                            <h3 class="text-white font-bold text-sm mb-2 line-clamp-2 group-hover:text-brand-yellow transition-colors">{{ $game->name }}</h3>
                            
                            <!-- Actions -->
                                 <div class="flex-1">
                                    <a href="{{ route('order.show', $game->slug) }}" wire:navigate class="block w-full px-3 py-2 text-xs font-bold text-center text-black bg-brand-yellow rounded-lg hover:bg-yellow-400 transition-all">
                                        Top Up
                                    </a>
                                </div>
                                <livewire:favorite-button :gameId="$game->id" :key="'fav-page-'.$game->id" />
                        </div>

                        <!-- Yellow Bottom Bar -->
                        <div class="h-1 bg-gradient-to-r from-brand-yellow to-yellow-600"></div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

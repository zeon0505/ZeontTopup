<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Semua Game</h2>
            <p class="text-gray-400 text-lg">Temukan game favorit Anda dan top up sekarang</p>
        </div>

        <!-- Search Bar -->
        <div class="max-w-xl mx-auto mb-12">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input wire:model.live.debounce.300ms="search" type="text" 
                    class="block w-full pl-10 pr-3 py-3 border border-gray-700 rounded-lg leading-5 bg-dark-800 text-gray-300 placeholder-gray-400 focus:outline-none focus:bg-dark-700 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition duration-150 ease-in-out" 
                    placeholder="Cari game...">
            </div>
        </div>

        @if($isDummy)
            <div class="max-w-3xl mx-auto mb-8 bg-yellow-500/10 border border-yellow-500/20 rounded-lg p-4 text-center">
                <p class="text-yellow-400 text-sm">
                    <span class="font-bold">Mode Demo:</span> Menampilkan data contoh karena database kosong. 
                    Silakan jalankan seeder untuk data asli: <code class="bg-black/30 px-2 py-1 rounded">php artisan db:seed --class=GameSeeder</code>
                </p>
            </div>
        @endif

        @if($games->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($games as $game)
                <a href="{{ route('order.show', $game->slug) }}" class="group relative bg-dark-800 rounded-xl overflow-hidden hover:shadow-2xl hover:shadow-indigo-500/20 transition-all duration-300 border border-white/5 hover:-translate-y-1">
                    <div class="aspect-[3/4] overflow-hidden relative">
                        @if($game->image)
                            <img src="{{ asset('storage/' . $game->image) }}" alt="{{ $game->name }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-full bg-dark-700 flex items-center justify-center">
                                <span class="text-gray-500">{{ $game->name }}</span>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-dark-900 via-transparent to-transparent opacity-80"></div>
                        
                        <!-- Heart Favorite Button -->
                        <div class="absolute top-2 left-2 z-10">
                            <livewire:favorite-button :gameId="$game->id" :key="'fav-list-'.$game->id" />
                        </div>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 p-4">
                        <h3 class="text-lg font-bold text-white mb-1 group-hover:text-indigo-400 transition-colors">{{ $game->name }}</h3>
                        <p class="text-sm text-gray-400 line-clamp-1">{{ $game->description }}</p>
                    </div>
                </a>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $games->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-300">Tidak ada game ditemukan</h3>
                <p class="mt-1 text-sm text-gray-500">Coba kata kunci lain.</p>
            </div>
        @endif
    </div>
</div>

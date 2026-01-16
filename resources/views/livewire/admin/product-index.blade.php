<div class="py-6">
    <!-- Header -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="text-3xl font-black text-white tracking-tight">Manage Products</h2>
                <p class="mt-1 text-sm text-gray-400">Select a game to manage its top-up packages</p>
            </div>
            
            <a href="{{ route('admin.products.create') }}" 
               class="group relative inline-flex items-center justify-center px-6 py-3 text-sm font-bold text-white transition-all duration-200 bg-indigo-600 font-pj rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 hover:bg-indigo-700">
                <div class="absolute -inset-2 rounded-xl bg-indigo-600/20 opacity-0 group-hover:opacity-100 transition-opacity duration-200 blur-lg"></div>
                + Add Product
            </a>
        </div>
    </div>

    <!-- Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Search -->
        <div class="mb-8">
            <div class="relative max-w-lg">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="search"
                    class="block w-full pl-10 pr-3 py-3 border border-gray-700 rounded-xl bg-dark-800 text-gray-300 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all shadow-lg" 
                    placeholder="Search games..." 
                >
            </div>
        </div>

        <!-- Game Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($games as $game)
                <div class="bg-dark-800 border border-gray-700/50 rounded-2xl overflow-hidden shadow-xl hover:border-brand-yellow/50 transition-all duration-300 group">
                    <div class="p-6 flex items-start gap-4">
                        <!-- Game Image -->
                        <div class="relative w-20 h-20 rounded-xl overflow-hidden flex-shrink-0 border border-gray-700">
                            @if($game->image)
                                <img src="{{ Storage::url($game->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-full bg-gray-700 flex items-center justify-center text-xs font-bold text-gray-400">
                                    {{ substr($game->name, 0, 2) }}
                                </div>
                            @endif
                        </div>

                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg font-bold text-white truncate group-hover:text-brand-yellow transition-colors">{{ $game->name }}</h3>
                            <p class="text-sm text-gray-400 mb-3">{{ $game->products_count }} Products Active</p>
                            
                            <a href="{{ route('admin.products.manage', $game->id) }}" 
                               class="inline-flex items-center px-4 py-2 text-xs font-bold text-black bg-brand-yellow rounded-lg hover:bg-yellow-400 transition-colors">
                                Manage Products
                                <svg class="w-3 h-3 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-800 mb-4">
                        <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-white">No active games found</h3>
                    <p class="text-gray-400">Make sure you have added games to the system.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $games->links() }}
        </div>
    </div>
</div>

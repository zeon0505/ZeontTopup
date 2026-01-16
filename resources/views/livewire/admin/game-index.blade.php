<div>
    <!-- Header -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="text-3xl font-black text-white tracking-tight">Games Management</h2>
                <p class="mt-1 text-sm text-gray-400">Manage your game library and configurations</p>
            </div>
            <a href="{{ route('admin.games.create') }}" 
               class="group relative inline-flex items-center justify-center px-6 py-3 text-sm font-bold text-white transition-all duration-200 bg-indigo-600 font-pj rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 hover:bg-indigo-700">
                <div class="absolute -inset-2 rounded-xl bg-indigo-600/20 opacity-0 group-hover:opacity-100 transition-opacity duration-200 blur-lg"></div>
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Add New Game
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
            <div class="relative overflow-hidden bg-green-500/10 border border-green-500/20 p-4 rounded-xl">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-green-500/20 rounded-lg">
                        <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <p class="text-green-400 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Content Card -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-dark-800 border border-gray-700/50 rounded-2xl overflow-hidden shadow-xl">
            <!-- Search & Filters -->
            <div class="p-6 border-b border-gray-700/50 space-y-4 md:space-y-0 md:flex md:items-center md:justify-between gap-4">
                <div class="flex-1 max-w-lg relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="search"
                        class="block w-full pl-10 pr-3 py-2.5 border border-gray-700 rounded-xl leading-5 bg-dark-900 text-gray-300 placeholder-gray-500 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 sm:text-sm transition-colors duration-200" 
                        placeholder="Search games by name or slug..." 
                    >
                </div>
                <div class="flex items-center gap-3">
                    <select 
                        wire:model.live="perPage"
                        class="block w-full pl-3 pr-10 py-2.5 text-base border-gray-700 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-xl bg-dark-900 text-gray-300"
                    >
                        <option value="10">10 / Returns</option>
                        <option value="25">25 / Returns</option>
                        <option value="50">50 / Returns</option>
                    </select>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-700/50 text-left">
                    <thead class="bg-dark-900/50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Game Info</th>
                            <th scope="col" class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Slug</th>
                            <th scope="col" class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Order</th>
                            <th scope="col" class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700/50 bg-dark-800">
                        @forelse($games as $game)
                            <tr class="hover:bg-dark-900/50 transition-colors duration-150 group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-12 w-12 relative group-hover:scale-110 transition-transform duration-300">
                                            @if($game->image)
                                                <img class="h-12 w-12 rounded-lg object-cover shadow-lg border border-gray-700" src="{{ Storage::url($game->image) }}" alt="{{ $game->name }}">
                                            @else
                                                <div class="h-12 w-12 rounded-lg bg-dark-900 flex items-center justify-center border border-gray-700">
                                                    <span class="text-xs font-bold text-gray-500">{{ substr($game->name, 0, 2) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-white group-hover:text-indigo-400 transition-colors">{{ $game->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $game->publisher ?? 'No Publisher' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="px-2.5 py-0.5 rounded-md bg-gray-700/30 border border-gray-700 text-xs font-medium text-gray-400 inline-block">
                                        {{ $game->slug }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-300 font-mono">{{ $game->sort_order }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button 
                                        wire:click="promptToggleActive({{ $game->id }})"
                                        wire:loading.attr="disabled"
                                        class="relative inline-flex items-center px-3 py-1 rounded-full text-xs font-bold transition-all duration-200 {{ $game->is_active ? 'bg-green-500/10 text-green-400 border border-green-500/20 hover:bg-green-500/20' : 'bg-red-500/10 text-red-400 border border-red-500/20 hover:bg-red-500/20' }}"
                                    >
                                        <span wire:loading.remove target="promptToggleActive({{ $game->id }})" class="w-1.5 h-1.5 rounded-full mr-2 {{ $game->is_active ? 'bg-green-400 animate-pulse' : 'bg-red-400' }}"></span>
                                        <span wire:loading target="promptToggleActive({{ $game->id }})" class="w-1.5 h-1.5 rounded-full mr-2 bg-indigo-500 animate-spin"></span>
                                        {{ $game->is_active ? 'Active' : 'Inactive' }}
                                    </button>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                        <a href="{{ route('admin.games.edit', $game) }}" 
                                           class="p-2 text-blue-400 hover:text-white hover:bg-blue-600 rounded-lg transition-all duration-200"
                                           title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        <button 
                                            wire:click="promptDelete({{ $game->id }})"
                                            wire:loading.attr="disabled"
                                            class="p-2 text-red-400 hover:text-white hover:bg-red-600 rounded-lg transition-all duration-200"
                                            title="Delete">
                                            <svg wire:loading.remove target="promptDelete({{ $game->id }})" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            <svg wire:loading target="promptDelete({{ $game->id }})" class="w-5 h-5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-24 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="p-4 bg-gray-800 rounded-full mb-4">
                                            <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                            </svg>
                                        </div>
                                        <p class="text-lg font-medium text-gray-300">No games found</p>
                                        <p class="text-sm text-gray-500 mt-1">Try adjusting your search or add a new game</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-700/50 bg-dark-900/30">
                {{ $games->links() }}
            </div>
        </div>
    </div>
</div>

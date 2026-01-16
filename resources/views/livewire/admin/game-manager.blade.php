<div>

    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-white mb-2">Game Catalog</h1>
            <p class="text-gray-400">Kelola semua game yang tersedia untuk top-up</p>
        </div>
        <button onclick="@this.openCreateModal()" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors font-medium shadow-lg shadow-indigo-600/20">
            <span class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add New Game
            </span>
        </button>
    </div>

    <!-- Game List -->
    <div class="bg-dark-800 rounded-xl border border-gray-700 overflow-hidden shadow-xl">
        <table class="w-full text-left">
            <thead class="bg-dark-700 text-gray-400 uppercase text-xs">
                <tr>
                    <th class="px-6 py-4">Image</th>
                    <th class="px-6 py-4">Name</th>
                    <th class="px-6 py-4">Slug</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Order</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @forelse($games as $game)
                <tr class="hover:bg-white/5 transition-colors">
                    <td class="px-6 py-4">
                        @if($game->image)
                            <img src="{{ asset('storage/' . $game->image) }}" alt="{{ $game->name }}" class="w-12 h-12 rounded-lg object-cover">
                        @else
                            <div class="w-12 h-12 rounded-lg bg-dark-700 flex items-center justify-center text-xs text-gray-500">No Img</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 font-medium text-white">{{ $game->name }}</td>
                    <td class="px-6 py-4 text-gray-400 font-mono text-sm">{{ $game->slug }}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs font-medium rounded-full {{ $game->is_active ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">
                            {{ $game->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-400">{{ $game->sort_order }}</td>
                    <td class="px-6 py-4 text-right space-x-3">
                        <button onclick="@this.openEditModal({{ $game->id }})" class="text-indigo-400 hover:text-indigo-300 font-medium">Edit</button>
                        <button onclick="if(confirm('Are you sure you want to delete this game?')) @this.delete({{ $game->id }})" class="text-red-400 hover:text-red-300 font-medium">Delete</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <svg class="w-16 h-16 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/>
                            </svg>
                            <p class="text-gray-500 font-medium">No games found</p>
                            <p class="text-sm text-gray-600">Start by adding your first game</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4 border-t border-gray-700 bg-dark-800/50">
            {{ $games->links() }}
        </div>
    </div>

    <!-- Modal -->
    @if($showModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
        <div class="bg-dark-800 rounded-xl border border-gray-700 w-full max-w-2xl p-8 shadow-2xl max-h-[90vh] overflow-y-auto">
            <h3 class="text-2xl font-bold text-white mb-6">{{ $editingGameId ? 'Edit Game' : 'Add New Game' }}</h3>
            
            <form wire:submit="save" class="space-y-6">
                <!-- Image Upload -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-3">Game Image</label>
                    <div class="flex items-center gap-6">
                        @if($image)
                            <img src="{{ $image->temporaryUrl() }}" class="w-24 h-24 rounded-lg object-cover border-2 border-indigo-500">
                        @elseif($existingImage)
                            <img src="{{ asset('storage/' . $existingImage) }}" class="w-24 h-24 rounded-lg object-cover border-2 border-gray-600">
                        @else
                            <div class="w-24 h-24 rounded-lg bg-dark-700 border-2 border-dashed border-gray-600 flex items-center justify-center text-gray-500 text-xs">No Image</div>
                        @endif
                        <input type="file" wire:model="image" class="text-sm text-gray-400 file:mr-4 file:py-2.5 file:px-6 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 file:cursor-pointer">
                    </div>
                    @error('image') <span class="text-red-400 text-sm mt-2 block">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-3">Name</label>
                        <input type="text" wire:model.live="name" class="w-full bg-dark-900 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20">
                        @error('name') <span class="text-red-400 text-sm mt-2 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-3">Slug</label>
                        <input type="text" wire:model="slug" class="w-full bg-dark-900 border border-gray-700 rounded-lg px-4 py-3 text-white font-mono text-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20">
                        @error('slug') <span class="text-red-400 text-sm mt-2 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-3">Description</label>
                    <textarea wire:model="description" rows="4" class="w-full bg-dark-900 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20"></textarea>
                    @error('description') <span class="text-red-400 text-sm mt-2 block">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-3">Sort Order</label>
                        <input type="number" wire:model="sort_order" class="w-full bg-dark-900 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20">
                        @error('sort_order') <span class="text-red-400 text-sm mt-2 block">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex items-end pb-3">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" wire:model="is_active" class="w-5 h-5 rounded border-gray-700 text-indigo-600 focus:ring-indigo-500 focus:ring-2 bg-dark-900">
                            <span class="text-sm font-medium text-gray-300">Active</span>
                        </label>
                    </div>
                </div>

                <div class="flex justify-end gap-4 mt-8 pt-6 border-t border-gray-700">
                    <button type="button" onclick="@this.set('showModal', false)" class="px-6 py-3 text-gray-400 hover:text-white transition-colors font-medium">Cancel</button>
                    <button type="submit" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors font-medium shadow-lg shadow-indigo-600/20">
                        {{ $editingGameId ? 'Update Game' : 'Create Game' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>

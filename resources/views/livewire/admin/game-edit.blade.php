<div class="py-6">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-black text-white tracking-tight">Edit Game</h2>
                <p class="mt-1 text-sm text-gray-400">Update configuration and details for <span class="text-indigo-400">{{ $name }}</span></p>
            </div>
            <button wire:click="cancel" class="p-2 text-gray-400 hover:text-white transition-colors rounded-lg hover:bg-gray-800">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Form Card -->
        <div class="bg-dark-800 border border-gray-700/50 rounded-2xl shadow-xl overflow-hidden backdrop-blur-sm">
            <form wire:submit="save">
                <div class="p-6 md:p-8 space-y-8">
                    <!-- Basic Info Section -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-bold text-white border-b border-gray-700/50 pb-2">Basic Information</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Game Name -->
                            <div class="space-y-2">
                                <label for="name" class="block text-sm font-medium text-gray-400">Game Name <span class="text-red-500">*</span></label>
                                <input 
                                    type="text" 
                                    id="name"
                                    wire:model.live="name"
                                    class="block w-full px-4 py-3 rounded-xl bg-dark-900 border border-gray-700 text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors duration-200"
                                    placeholder="e.g., Mobile Legends"
                                >
                                @error('name') <p class="text-sm text-red-400 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Publisher -->
                            <div class="space-y-2">
                                <label for="publisher" class="block text-sm font-medium text-gray-400">Publisher</label>
                                <input 
                                    type="text" 
                                    id="publisher"
                                    wire:model="publisher"
                                    class="block w-full px-4 py-3 rounded-xl bg-dark-900 border border-gray-700 text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors duration-200"
                                    placeholder="e.g., Moonton"
                                >
                                @error('publisher') <p class="text-sm text-red-400 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Category -->
                            <div class="space-y-2">
                                <label for="category" class="block text-sm font-medium text-gray-400">Category <span class="text-red-500">*</span></label>
                                <select 
                                    id="category"
                                    wire:model="category"
                                    class="block w-full px-4 py-3 rounded-xl bg-dark-900 border border-gray-700 text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors duration-200"
                                >
                                    <option value="Top Up Games">Top Up Games</option>
                                    <option value="Specialist MLBB">Specialist MLBB</option>
                                    <option value="Specialist PUBGM">Specialist PUBGM</option>
                                    <option value="Voucher">Voucher</option>
                                </select>
                                @error('category') <p class="text-sm text-red-400 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Slug -->
                            <div class="space-y-2">
                                <label for="slug" class="block text-sm font-medium text-gray-400">Slug <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input 
                                        type="text" 
                                        id="slug"
                                        wire:model="slug"
                                        class="block w-full px-4 py-3 rounded-xl bg-dark-900 border border-gray-700 text-gray-300 placeholder-gray-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors duration-200 font-mono text-sm"
                                    >
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-600 mt-1">Changing the slug may affect existing links.</p>
                                @error('slug') <p class="text-sm text-red-400 mt-1">{{ $message }}</p> @enderror
                            </div>
                            
                            <!-- API Endpoint -->
                            <div class="space-y-2">
                                <label for="api_endpoint" class="block text-sm font-medium text-gray-400">API Endpoint</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                        </svg>
                                    </span>
                                    <input 
                                        type="text" 
                                        id="api_endpoint"
                                        wire:model="api_endpoint"
                                        class="block w-full pl-11 pr-4 py-3 rounded-xl bg-dark-900 border border-gray-700 text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors duration-200 font-mono text-sm"
                                        placeholder="/api/games/..."
                                    >
                                </div>
                                @error('api_endpoint') <p class="text-sm text-red-400 mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="space-y-2">
                            <label for="description" class="block text-sm font-medium text-gray-400">Description</label>
                            <textarea 
                                id="description"
                                wire:model="description"
                                rows="4"
                                class="block w-full px-4 py-3 rounded-xl bg-dark-900 border border-gray-700 text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors duration-200 resize-none"
                                placeholder="Write a brief description about the game..."
                            ></textarea>
                            @error('description') <p class="text-sm text-red-400 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Visuals & Configuration -->
                    <div class="space-y-6 pt-6 border-t border-gray-700/50">
                        <h3 class="text-lg font-bold text-white border-b border-gray-700/50 pb-2">Visuals & Configuration</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Image Upload -->
                            <div class="space-y-4">
                                <label class="block text-sm font-medium text-gray-400">Game Image</label>
                                <div class="flex items-start gap-4 p-4 bg-dark-900 rounded-xl border border-dashed border-gray-700 hover:border-indigo-500/50 transition-colors duration-200">
                                    <div class="flex-shrink-0">
                                        @if ($image)
                                            <img src="{{ $image->temporaryUrl() }}" class="w-24 h-24 rounded-lg object-cover border border-gray-600 shadow-lg" alt="Preview">
                                        @elseif ($existingImage)
                                            <img src="{{ Storage::url($existingImage) }}" class="w-24 h-24 rounded-lg object-cover border border-gray-600 shadow-lg" alt="Current">
                                        @else
                                            <div class="w-24 h-24 rounded-lg bg-gray-800 flex items-center justify-center border border-gray-700">
                                                <svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2-2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 space-y-2">
                                        <div class="relative group">
                                            <label for="image-upload" class="cursor-pointer inline-flex px-4 py-2 bg-gray-800 border border-gray-600 rounded-lg text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white transition-all duration-200 shadow-sm">
                                                Change Image
                                                <input id="image-upload" type="file" wire:model="image" class="hidden">
                                            </label>
                                            <p class="text-xs text-gray-500 mt-2">JPG, PNG or GIF. Max 1MB.</p>
                                        </div>
                                        <div wire:loading wire:target="image" class="text-xs text-indigo-400 font-medium animate-pulse">
                                            Uploading...
                                        </div>
                                        @error('image') <p class="text-sm text-red-400">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Sort & Status -->
                            <div class="space-y-6">
                                <div class="space-y-2">
                                    <label for="sort_order" class="block text-sm font-medium text-gray-400">Sort Order</label>
                                    <input 
                                        type="number" 
                                        id="sort_order"
                                        wire:model="sort_order"
                                        min="0"
                                        class="block w-full px-4 py-3 rounded-xl bg-dark-900 border border-gray-700 text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors duration-200"
                                    >
                                    @error('sort_order') <p class="text-sm text-red-400 mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="pt-2">
                                    <label class="flex items-start gap-3 p-4 rounded-xl bg-dark-900 border border-gray-700 cursor-pointer hover:border-gray-600 transition-colors duration-200 group">
                                        <div class="flex items-center h-5">
                                            <input 
                                                type="checkbox" 
                                                wire:model="is_active"
                                                class="w-5 h-5 rounded border-gray-600 bg-gray-800 text-indigo-600 focus:ring-indigo-500 focus:ring-offset-gray-900"
                                            >
                                        </div>
                                        <div class="text-sm">
                                            <span class="font-bold text-white group-hover:text-indigo-400 transition-colors">Active Status</span>
                                            <p class="text-gray-500 text-xs mt-1">Enable to show this game on the public catalog immediately.</p>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="px-6 md:px-8 py-6 bg-dark-900/50 border-t border-gray-700/50 flex items-center justify-end gap-4">
                    <button 
                        type="button"
                        wire:click="cancel"
                        class="px-5 py-2.5 rounded-xl text-sm font-bold text-gray-400 hover:text-white hover:bg-gray-700/50 transition-all duration-200"
                    >
                        Cancel
                    </button>
                    <button 
                        type="submit"
                        class="group relative inline-flex items-center justify-center px-6 py-2.5 text-sm font-bold text-white transition-all duration-200 bg-indigo-600 font-pj rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 hover:bg-indigo-700"
                    >
                        <div class="absolute -inset-2 rounded-xl bg-indigo-600/20 opacity-0 group-hover:opacity-100 transition-opacity duration-200 blur-lg"></div>
                        <span class="relative flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Save Changes
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

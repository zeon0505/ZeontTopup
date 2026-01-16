<div class="py-6">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-black text-white tracking-tight">Add New Product</h2>
                <p class="mt-1 text-sm text-gray-400">Create a new product item for your games</p>
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
                        <h3 class="text-lg font-bold text-white border-b border-gray-700/50 pb-2">Product Details</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Game Selection -->
                            <div class="space-y-2">
                                <label for="game_id" class="block text-sm font-medium text-gray-400">Select Game <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <select 
                                        id="game_id"
                                        wire:model="game_id"
                                        class="block w-full px-4 py-3 rounded-xl bg-dark-900 border border-gray-700 text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors duration-200 appearance-none"
                                    >
                                        <option value="">-- Choose Game --</option>
                                        @foreach($games as $game)
                                            <option value="{{ $game->id }}">{{ $game->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                </div>
                                @error('game_id') <p class="text-sm text-red-400 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Product Name -->
                            <div class="space-y-2">
                                <label for="name" class="block text-sm font-medium text-gray-400">Product Name <span class="text-red-500">*</span></label>
                                <input 
                                    type="text" 
                                    id="name"
                                    wire:model="name"
                                    class="block w-full px-4 py-3 rounded-xl bg-dark-900 border border-gray-700 text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors duration-200"
                                    placeholder="e.g., 100 Diamonds"
                                >
                                @error('name') <p class="text-sm text-red-400 mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="space-y-2">
                            <label for="description" class="block text-sm font-medium text-gray-400">Description</label>
                            <textarea 
                                id="description"
                                wire:model="description"
                                rows="3"
                                class="block w-full px-4 py-3 rounded-xl bg-dark-900 border border-gray-700 text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors duration-200 resize-none"
                                placeholder="Optional description..."
                            ></textarea>
                            @error('description') <p class="text-sm text-red-400 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Pricing & Inventory -->
                    <div class="space-y-6 pt-6 border-t border-gray-700/50">
                        <h3 class="text-lg font-bold text-white border-b border-gray-700/50 pb-2">Pricing & Inventory</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Pricing -->
                            <div class="space-y-4">
                                <div class="space-y-2">
                                    <label for="price" class="block text-sm font-medium text-gray-400">Price (Rp) <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500 font-medium">Rp</span>
                                        <input 
                                            type="number" 
                                            id="price"
                                            wire:model="price"
                                            min="0"
                                            class="block w-full pl-10 pr-4 py-3 rounded-xl bg-dark-900 border border-gray-700 text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors duration-200"
                                        >
                                    </div>
                                    @error('price') <p class="text-sm text-red-400 mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="space-y-2">
                                    <label for="original_price" class="block text-sm font-medium text-gray-400">Original Price (Rp)</label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500 font-medium">Rp</span>
                                        <input 
                                            type="number" 
                                            id="original_price"
                                            wire:model="original_price"
                                            min="0"
                                            class="block w-full pl-10 pr-4 py-3 rounded-xl bg-dark-900 border border-gray-700 text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors duration-200"
                                            placeholder="Optional"
                                        >
                                    </div>
                                    <p class="text-xs text-gray-500">Set this higher than Price to show a discount.</p>
                                    @error('original_price') <p class="text-sm text-red-400 mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <!-- Stock & Status -->
                            <div class="space-y-6">
                                <div class="space-y-2">
                                    <label for="quantity" class="block text-sm font-medium text-gray-400">Stock / Quantity <span class="text-red-500">*</span></label>
                                    <input 
                                        type="number" 
                                        id="quantity"
                                        wire:model="quantity"
                                        min="0"
                                        class="block w-full px-4 py-3 rounded-xl bg-dark-900 border border-gray-700 text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors duration-200"
                                    >
                                    @error('quantity') <p class="text-sm text-red-400 mt-1">{{ $message }}</p> @enderror
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
                                            <p class="text-gray-500 text-xs mt-1">Product will be visible to users when active.</p>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Automation (Provider) -->
                    <div class="space-y-6 pt-6 border-t border-gray-700/50">
                        <h3 class="text-lg font-bold text-white border-b border-gray-700/50 pb-2">Automation (Provider)</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Provider Name -->
                            <div class="space-y-2">
                                <label for="provider_name" class="block text-sm font-medium text-gray-400">Select Provider</label>
                                <div class="relative">
                                    <select 
                                        id="provider_name"
                                        wire:model="provider_name"
                                        class="block w-full px-4 py-3 rounded-xl bg-dark-900 border border-gray-700 text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors duration-200 appearance-none"
                                    >
                                        <option value="">-- Manual (No Auto-Delivery) --</option>
                                        <option value="digiflazz">Digiflazz</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500">Choose "Manual" if you want to process orders yourself.</p>
                                @error('provider_name') <p class="text-sm text-red-400 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Provider SKU -->
                            <div class="space-y-2">
                                <label for="provider_product_code" class="block text-sm font-medium text-gray-400">Provider Product Code (SKU)</label>
                                <input 
                                    type="text" 
                                    id="provider_product_code"
                                    wire:model="provider_product_code"
                                    class="block w-full px-4 py-3 rounded-xl bg-dark-900 border border-gray-700 text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors duration-200"
                                    placeholder="e.g., ml10"
                                >
                                <p class="text-xs text-gray-500">The SKU code from your provider dashboard.</p>
                                @error('provider_product_code') <p class="text-sm text-red-400 mt-1">{{ $message }}</p> @enderror
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Create Product
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

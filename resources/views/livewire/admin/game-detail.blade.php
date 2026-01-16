<div class="py-6">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-4">
                    <button wire:click="back" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                    </button>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Game Details</h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">View complete game information</p>
                    </div>
                </div>
                <button 
                    wire:click="edit"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors"
                >
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Game
                </button>
            </div>
        </div>

        <!-- Game Information -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden mb-6">
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Basic Information</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Game Image -->
                    <div class="md:col-span-1">
                        @if($game->image)
                            <img src="{{ Storage::url($game->image) }}" alt="{{ $game->name }}" class="w-full rounded-lg shadow-lg">
                        @else
                            <div class="w-full aspect-square bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Game Details -->
                    <div class="md:col-span-2 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Game Name</label>
                            <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $game->name }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Slug</label>
                            <p class="text-gray-900 dark:text-gray-100 font-mono bg-gray-100 dark:bg-gray-900 px-3 py-1 rounded inline-block">
                                {{ $game->slug }}
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Description</label>
                            <p class="text-gray-900 dark:text-gray-100">
                                {{ $game->description ?: 'No description available' }}
                            </p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Sort Order</label>
                                <p class="text-gray-900 dark:text-gray-100">{{ $game->sort_order }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Status</label>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $game->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                    {{ $game->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>

                        @if($game->api_endpoint)
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">API Endpoint</label>
                                <p class="text-gray-900 dark:text-gray-100 font-mono bg-gray-100 dark:bg-gray-900 px-3 py-1 rounded">
                                    {{ $game->api_endpoint }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Products -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden mb-6">
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Associated Products</h3>
                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ $game->products->count() }} products</span>
                </div>
            </div>
            <div class="p-6">
                @if($game->products->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($game->products as $product)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:shadow-md transition-shadow">
                                <h4 class="font-semibold text-gray-900 dark:text-gray-100">{{ $product->name }}</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $product->description }}</p>
                                <div class="mt-3 flex items-center justify-between">
                                    <span class="text-lg font-bold text-indigo-600 dark:text-indigo-400">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                    @if($product->discount_price)
                                        <span class="text-sm text-gray-500 line-through">
                                            Rp {{ number_format($product->discount_price, 0, ',', '.') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                        <p class="text-gray-500 dark:text-gray-400">No products available for this game</p>
                        <a href="{{ route('admin.products.index') }}" class="text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 text-sm mt-2 inline-block">
                            Add products →
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Metadata -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Metadata</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Created At</label>
                        <p class="text-gray-900 dark:text-gray-100">{{ $game->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Last Updated</label>
                        <p class="text-gray-900 dark:text-gray-100">{{ $game->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Game ID</label>
                        <p class="text-gray-900 dark:text-gray-100 font-mono">{{ $game->id }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

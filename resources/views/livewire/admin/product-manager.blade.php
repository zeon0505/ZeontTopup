<div>
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-white">Product Management</h2>
        <button wire:click="openCreateModal" class="px-4 py-2 font-semibold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
            Add New Product
        </button>
    </div>

    <!-- Filter -->
    <div class="mb-6">
        <select wire:model.live="gameId" class="px-4 py-2 text-white bg-gray-800 border border-gray-700 rounded-lg">
            <option value="">All Games</option>
            @foreach($games as $game)
                <option value="{{ $game->id }}">{{ $game->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Products Table -->
    <div class="overflow-hidden bg-gray-800 border border-gray-700 rounded-xl">
        <table class="min-w-full divide-y divide-gray-700">
            <thead class="bg-gray-900">
                <tr>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-400 uppercase">Game</th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-400 uppercase">Product</th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-400 uppercase">Price</th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-400 uppercase">Original Price</th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-400 uppercase">Quantity</th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-400 uppercase">Status</th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-400 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @foreach($products as $product)
                    <tr class="hover:bg-gray-700/50">
                        <td class="px-6 py-4 text-sm text-white whitespace-nowrap">{{ $product->game->name }}</td>
                        <td class="px-6 py-4 text-sm text-white whitespace-nowrap">{{ $product->name }}</td>
                        <td class="px-6 py-4 text-sm text-white whitespace-nowrap">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-400 whitespace-nowrap">
                            @if($product->original_price)
                                Rp {{ number_format($product->original_price, 0, ',', '.') }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-white whitespace-nowrap">{{ $product->quantity }}</td>
                        <td class="px-6 py-4 text-sm whitespace-nowrap">
                            @if($product->is_active)
                                <span class="px-2 py-1 text-xs font-medium text-green-400 bg-green-900/50 rounded-full">Active</span>
                            @else
                                <span class="px-2 py-1 text-xs font-medium text-red-400 bg-red-900/50 rounded-full">Inactive</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-right whitespace-nowrap">
                            <button wire:click="openEditModal({{ $product->id }})" class="mr-3 text-indigo-400 hover:text-indigo-300">
                                Edit
                            </button>
                            <button wire:click="delete({{ $product->id }})" wire:confirm="Are you sure?" class="text-red-400 hover:text-red-300">
                                Delete
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $products->links() }}
    </div>

    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" wire:click="showModal = false">
            <div class="w-full max-w-2xl p-6 bg-gray-800 rounded-xl" wire:click.stop>
                <h3 class="mb-4 text-xl font-bold text-white">{{ $editingProductId ? 'Edit Product' : 'Add New Product' }}</h3>
                
                <form wire:submit.prevent="save" class="space-y-4">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-300">Game</label>
                        <select wire:model="gameId" class="w-full px-4 py-2 text-white bg-gray-900 border border-gray-700 rounded-lg">
                            <option value="">Select Game</option>
                            @foreach($games as $game)
                                <option value="{{ $game->id }}">{{ $game->name }}</option>
                            @endforeach
                        </select>
                        @error('gameId') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-300">Product Name</label>
                        <input wire:model="name" type="text" class="w-full px-4 py-2 text-white bg-gray-900 border border-gray-700 rounded-lg">
                        @error('name') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-300">Description</label>
                        <textarea wire:model="description" class="w-full px-4 py-2 text-white bg-gray-900 border border-gray-700 rounded-lg" rows="3"></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-300">Price</label>
                            <input wire:model="price" type="number" class="w-full px-4 py-2 text-white bg-gray-900 border border-gray-700 rounded-lg">
                            @error('price') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-300">Original Price</label>
                            <input wire:model="original_price" type="number" class="w-full px-4 py-2 text-white bg-gray-900 border border-gray-700 rounded-lg">
                        </div>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-300">Quantity</label>
                        <input wire:model="quantity" type="number" class="w-full px-4 py-2 text-white bg-gray-900 border border-gray-700 rounded-lg">
                        @error('quantity') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center">
                        <input wire:model="is_active" type="checkbox" id="is_active" class="w-4 h-4 text-indigo-600 bg-gray-900 border-gray-700 rounded">
                        <label for="is_active" class="ml-2 text-sm text-gray-300">Active</label>
                    </div>

                    <div class="flex justify-end gap-3 pt-4">
                        <button type="button" wire:click="showModal = false" class="px-4 py-2 text-gray-300 bg-gray-700 rounded-lg hover:bg-gray-600">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 font-semibold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>

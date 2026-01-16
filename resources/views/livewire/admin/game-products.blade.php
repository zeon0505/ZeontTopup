<div class="bg-dark-800 border border-gray-700/50 rounded-2xl overflow-hidden shadow-xl">
    <!-- Header/Actions -->
    <div class="p-6 border-b border-gray-700/50 flex justify-between items-center">
        <h3 class="text-xl font-bold text-white">Products List</h3>
        <a href="{{ route('admin.products.create') }}?game_id={{ $game->id }}" 
           class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl transition-colors">
            + Add Product
        </a>
    </div>

    <!-- Search -->
    <div class="p-6 border-b border-gray-700/50">
        <input 
            type="text" 
            wire:model.live.debounce.300ms="search"
            class="block w-full px-4 py-3 border border-gray-700 rounded-xl bg-dark-900 text-gray-300 placeholder-gray-500 focus:ring-indigo-500 focus:border-indigo-500" 
            placeholder="Search products..." 
        >
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-700/50 text-left">
            <thead class="bg-dark-900/50">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase">Product Name</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase">Price</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase">Status</th>
                    <th class="px-6 py-4 text-right text-xs font-bold text-gray-400 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700/50 bg-dark-800">
                @forelse($products as $product)
                    <tr class="hover:bg-dark-900/50 transition-colors">
                        <td class="px-6 py-4 text-sm font-bold text-white">{{ $product->name }}</td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-brand-yellow">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <button wire:click="toggleActive('{{ $product->id }}')" 
                                class="px-3 py-1 rounded-full text-xs font-bold {{ $product->is_active ? 'bg-green-500/10 text-green-400' : 'bg-red-500/10 text-red-400' }}">
                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                            </button>
                        </td>
                        <td class="px-6 py-4 text-right flex justify-end gap-2">
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="p-2 text-indigo-400 hover:text-white hover:bg-indigo-600 rounded-lg transition-all duration-200" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <button 
                                @click="$dispatch('confirm-action', { 
                                    event: 'delete', 
                                    params: { productId: '{{ $product->id }}' },
                                    title: 'Hapus Produk?',
                                    text: 'Paket ini akan dihapus dari daftar topup game!',
                                    icon: 'warning',
                                    confirmButtonColor: '#EF4444',
                                    confirmText: 'Ya, Hapus!'
                                })"
                                class="p-2 text-red-400 hover:text-white hover:bg-red-600 rounded-lg transition-all duration-200"
                                title="Delete"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-500">No products found for this game.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="p-4 border-t border-gray-700/50">
        {{ $products->links() }}
    </div>
</div>

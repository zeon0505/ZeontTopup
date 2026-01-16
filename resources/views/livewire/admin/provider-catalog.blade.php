<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h2 class="text-3xl font-black text-white tracking-tight">Katalog Digiflazz</h2>
                <p class="mt-1 text-sm text-gray-400">Lihat semua kode SKU dan harga modal asli dari provider</p>
            </div>
            <div class="bg-indigo-600/10 border border-indigo-500/20 rounded-2xl px-6 py-3 flex items-center gap-4">
                <div class="p-2 bg-indigo-600 rounded-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-indigo-400 font-bold uppercase tracking-wider">Saldo Provider</p>
                    <p class="text-xl font-black text-white">Rp {{ number_format($balance, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="relative">
                <input wire:model.live="search" type="text" placeholder="Cari nama produk atau SKU..." class="w-full pl-10 pr-4 py-3 rounded-xl bg-gray-800 border border-gray-700 text-white focus:border-indigo-500 transition-all">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </div>
            <select wire:model.live="category" class="px-4 py-3 rounded-xl bg-gray-800 border border-gray-700 text-white focus:border-indigo-500">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}">{{ $cat }}</option>
                @endforeach
            </select>
            <select wire:model.live="brand" class="px-4 py-3 rounded-xl bg-gray-800 border border-gray-700 text-white focus:border-indigo-500">
                <option value="">Semua Brand</option>
                @foreach($brands as $b)
                    <option value="{{ $b }}">{{ $b }}</option>
                @endforeach
            </select>
        </div>

        <!-- Catalog Table -->
        <div class="bg-gray-800 border border-gray-700 rounded-3xl overflow-hidden shadow-2xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-900/50 border-b border-gray-700">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Produk</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-center">Buyer SKU Code</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Harga Modal</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700/50">
                        @forelse($products as $product)
                            <tr class="hover:bg-gray-700/30 transition-colors group">
                                <td class="px-6 py-4">
                                    <p class="text-white font-bold group-hover:text-indigo-400 transition-colors">{{ $product['product_name'] }}</p>
                                    <p class="text-xs text-gray-500">{{ $product['brand'] }} • {{ $product['category'] }}</p>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-gray-900 border border-gray-700 rounded-lg group/sku cursor-pointer hover:border-indigo-500 transition-all" 
                                         onclick="navigator.clipboard.writeText('{{ $product['buyer_sku_code'] }}'); alert('SKU Berhasil di Copy!')">
                                        <code class="text-indigo-400 font-mono text-sm">{{ $product['buyer_sku_code'] }}</code>
                                        <svg class="w-4 h-4 text-gray-600 group-hover/sku:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/>
                                        </svg>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-emerald-400 font-bold">Rp {{ number_format($product['price'], 0, ',', '.') }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($product['seller_name'] === 'Digiflazz' || ($product['unlimited_stock'] ?? false) || ($product['stock'] ?? 0) > 0)
                                        <span class="px-2 py-1 text-[10px] font-black uppercase bg-emerald-500/10 text-emerald-500 rounded-md border border-emerald-500/20">Tersedia</span>
                                    @else
                                        <span class="px-2 py-1 text-[10px] font-black uppercase bg-red-500/10 text-red-500 rounded-md border border-red-500/20">Habis</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        <p class="text-gray-400 font-medium">Data tidak ditemukan atau API Key salah.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

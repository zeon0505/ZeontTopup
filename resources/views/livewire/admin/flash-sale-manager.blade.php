<div class="p-6">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-black text-white uppercase tracking-tight italic">Flash Sale Manager</h1>
            <p class="text-gray-400 text-sm mt-1">Atur promo diskon kilat untuk produk unggulan</p>
        </div>
        <button wire:click="$set('showCreateModal', true)" class="px-6 py-3 bg-brand-yellow hover:bg-yellow-400 text-black font-black uppercase tracking-widest text-xs rounded-xl transition-all shadow-lg shadow-brand-yellow/20">
            Tambah Flash Sale Baru
        </button>
    </div>

    <!-- Stats Row (Quick Glance) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-dark-800 border border-gray-700/50 rounded-2xl p-6">
            <h4 class="text-gray-500 text-xs font-bold uppercase tracking-widest mb-1">Total Promo</h4>
            <div class="text-3xl font-black text-white">{{ $flashSales->total() }}</div>
        </div>
        <div class="bg-dark-800 border border-brand-yellow/20 rounded-2xl p-6 relative overflow-hidden">
            <h4 class="text-brand-yellow text-xs font-bold uppercase tracking-widest mb-1">Sedang Aktif</h4>
            <div class="text-3xl font-black text-white">{{ $flashSales->where('is_active', true)->where('end_time', '>', now())->count() }}</div>
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-brand-yellow/5 blur-2xl rounded-full"></div>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="mb-6 p-4 bg-green-500/10 border border-green-500/20 text-green-400 rounded-xl text-sm font-bold animate-pulse">
            {{ session('success') }}
        </div>
    @endif

    <!-- Table -->
    <div class="bg-dark-800 border border-gray-700/50 rounded-3xl overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-dark-900/50 border-b border-gray-700/50">
                        <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">Produk / Game</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">Harga Promo</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">Jadwal</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest text-center">Status</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700/50">
                    @forelse($flashSales as $sale)
                        <tr class="hover:bg-dark-700/30 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-dark-900 border border-gray-700 flex items-center justify-center overflow-hidden">
                                        <img src="{{ Storage::url($sale->product->game->image) }}" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-white">{{ $sale->product->name }}</div>
                                        <div class="text-[10px] text-gray-500 font-bold uppercase tracking-wider">{{ $sale->product->game->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-brand-yellow italic">Rp {{ number_format($sale->discount_price, 0, ',', '.') }}</div>
                                <div class="text-[10px] text-gray-500 line-through">Normal: Rp {{ number_format($sale->product->price, 0, ',', '.') }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-xs text-gray-300 font-medium">Mulai: {{ $sale->start_time->format('d M, H:i') }}</div>
                                <div class="text-xs text-gray-300 font-medium">Selesai: {{ $sale->end_time->format('d M, H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @php
                                    $isRunning = $sale->is_active && $sale->start_time <= now() && $sale->end_time > now();
                                @endphp
                                @if($isRunning)
                                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-green-500/10 border border-green-500/20 text-[10px] font-black text-green-500 uppercase tracking-widest">Running</span>
                                @elseif(!$sale->is_active)
                                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-gray-500/10 border border-gray-500/20 text-[10px] font-black text-gray-500 uppercase tracking-widest">Disabled</span>
                                @elseif($sale->start_time > now())
                                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-blue-500/10 border border-blue-500/20 text-[10px] font-black text-blue-500 uppercase tracking-widest">Upcoming</span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-red-500/10 border border-red-500/20 text-[10px] font-black text-red-500 uppercase tracking-widest">Ended</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button wire:click="toggleStatus('{{ $sale->id }}')" class="p-2 text-gray-400 hover:text-white transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                    </button>
                                    <button onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" wire:click="deleteFlashSale('{{ $sale->id }}')" class="p-2 text-red-400 hover:text-red-500 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="text-gray-500 font-bold uppercase tracking-widest text-xs italic">Belum ada flash sale yang diatur.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($flashSales->hasPages())
            <div class="px-6 py-4 bg-dark-900/50 border-t border-gray-700/50">
                {{ $flashSales->links() }}
            </div>
        @endif
    </div>

    <!-- Create Modal -->
    @if($showCreateModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-dark-900/80 backdrop-blur-sm transition-opacity" wire:click="$set('showCreateModal', false)"></div>

                <div class="inline-block align-bottom bg-dark-800 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-700">
                    <div class="p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-black text-white uppercase tracking-tight italic">Buat Flash Sale Baru</h3>
                            <button wire:click="$set('showCreateModal', false)" class="text-gray-400 hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>

                        <form wire:submit.prevent="createFlashSale" class="space-y-5">
                            <!-- Game Selection -->
                            <div>
                                <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Pilih Game</label>
                                <select wire:model.live="selectedGameId" class="w-full bg-dark-900 border border-gray-700 rounded-xl px-4 py-3 text-white text-sm focus:ring-1 focus:ring-brand-yellow focus:border-brand-yellow transition-all">
                                    <option value="">-- Pilih Game --</option>
                                    @foreach($games as $game)
                                        <option value="{{ $game->id }}">{{ $game->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Product Selection -->
                            @if($selectedGameId)
                                <div>
                                    <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Pilih Produk</label>
                                    <select wire:model="productId" class="w-full bg-dark-900 border border-gray-700 rounded-xl px-4 py-3 text-white text-sm focus:ring-1 focus:ring-brand-yellow focus:border-brand-yellow transition-all">
                                        <option value="">-- Pilih Produk --</option>
                                        @foreach($availableProducts as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }} (Rp {{ number_format($product->price, 0) }})</option>
                                        @endforeach
                                    </select>
                                    @error('productId') <span class="text-red-500 text-[10px] font-bold mt-1 uppercase">{{ $message }}</span> @enderror
                                </div>
                            @endif

                            <!-- Discount Price -->
                            <div>
                                <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Harga Diskon (Rp)</label>
                                <input type="number" wire:model="discountPrice" class="w-full bg-dark-900 border border-gray-700 rounded-xl px-4 py-3 text-white text-sm focus:ring-1 focus:ring-brand-yellow focus:border-brand-yellow placeholder-gray-600 shadow-inner" placeholder="Contoh: 45000">
                                @error('discountPrice') <span class="text-red-500 text-[10px] font-bold mt-1 uppercase">{{ $message }}</span> @enderror
                            </div>

                            <!-- Schedule -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Waktu Mulai</label>
                                    <input type="datetime-local" wire:model="startTime" class="w-full bg-dark-900 border border-gray-700 rounded-xl px-4 py-3 text-white text-sm focus:ring-1 focus:ring-brand-yellow focus:border-brand-yellow transition-all">
                                    @error('startTime') <span class="text-red-500 text-[10px] font-bold mt-1 uppercase">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Waktu Selesai</label>
                                    <input type="datetime-local" wire:model="endTime" class="w-full bg-dark-900 border border-gray-700 rounded-xl px-4 py-3 text-white text-sm focus:ring-1 focus:ring-brand-yellow focus:border-brand-yellow transition-all">
                                    @error('endTime') <span class="text-red-500 text-[10px] font-bold mt-1 uppercase">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <button type="submit" class="w-full py-4 bg-brand-yellow hover:bg-yellow-400 text-black font-black uppercase tracking-widest text-sm rounded-2xl transition-all shadow-lg shadow-brand-yellow/20 mt-4">
                                Simpan Flash Sale
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

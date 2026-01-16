<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-white italic tracking-wider">VOUCHER MANAGEMENT</h1>
            <p class="text-gray-400 text-sm">Create and manage discount codes.</p>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-500/10 border border-green-500/20 text-green-500 p-4 rounded-xl flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form Section -->
        <div class="lg:col-span-1">
            <div class="bg-dark-800 border border-gray-700/50 rounded-2xl p-6 sticky top-6">
                <h2 class="text-lg font-bold text-white mb-4 border-b border-gray-700/50 pb-2">
                    {{ $isEdit ? 'Edit Voucher' : 'Create New Voucher' }}
                </h2>
                
                <form wire:submit.prevent="store" class="space-y-4">
                    <!-- Code -->
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Voucher Code</label>
                        <input type="text" wire:model="code" class="w-full bg-dark-900 border border-gray-700 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-brand-yellow focus:border-transparent uppercase placeholder-gray-600" placeholder="e.g. ZEON10">
                        @error('code') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Type & Amount -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1">Type</label>
                            <select wire:model="discount_type" class="w-full bg-dark-900 border border-gray-700 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-brand-yellow focus:border-transparent">
                                <option value="fixed">Fixed (Rp)</option>
                                <option value="percent">Percent (%)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1">Amount</label>
                            <input type="number" wire:model="amount" class="w-full bg-dark-900 border border-gray-700 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-brand-yellow focus:border-transparent" placeholder="0">
                            @error('amount') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Min Purchase & Max Discount -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1">Min Purchase</label>
                            <input type="number" wire:model="min_purchase" class="w-full bg-dark-900 border border-gray-700 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-brand-yellow focus:border-transparent" placeholder="Optional">
                        </div>
                        <div x-show="$wire.discount_type === 'percent'">
                            <label class="block text-sm font-medium text-gray-400 mb-1">Max Disc (Rp)</label>
                            <input type="number" wire:model="max_discount" class="w-full bg-dark-900 border border-gray-700 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-brand-yellow focus:border-transparent" placeholder="Optional">
                        </div>
                    </div>

                    <!-- Validity -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1">Valid From</label>
                            <input type="datetime-local" wire:model="valid_from" class="w-full bg-dark-900 border border-gray-700 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-brand-yellow focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1">Valid Until</label>
                            <input type="datetime-local" wire:model="valid_until" class="w-full bg-dark-900 border border-gray-700 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-brand-yellow focus:border-transparent">
                        </div>
                    </div>

                    <!-- Usage Limit -->
                    <div>
                         <label class="block text-sm font-medium text-gray-400 mb-1">Usage Limit</label>
                         <input type="number" wire:model="usage_limit" class="w-full bg-dark-900 border border-gray-700 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-brand-yellow focus:border-transparent" placeholder="Optional (0 for unlimited)">
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-3 pt-4">
                         @if($isEdit)
                            <button type="button" wire:click="create" class="flex-1 px-4 py-2 bg-dark-700 text-white font-bold rounded-xl hover:bg-dark-600 transition-colors">
                                Cancel
                            </button>
                        @endif
                        <button type="submit" class="flex-1 px-4 py-2 bg-brand-yellow text-black font-bold rounded-xl hover:bg-yellow-400 transition-all shadow-[0_0_15px_rgba(255,193,7,0.3)]">
                            {{ $isEdit ? 'Update Voucher' : 'Create Voucher' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- List Section -->
        <div class="lg:col-span-2">
            <div class="bg-dark-800 border border-gray-700/50 rounded-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-dark-900/50 text-gray-400 text-sm uppercase">
                            <tr>
                                <th class="px-6 py-4">Code</th>
                                <th class="px-6 py-4">Discount</th>
                                <th class="px-6 py-4">Usage</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700/50">
                            @foreach($vouchers as $voucher)
                                <tr class="hover:bg-dark-700/30 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-white font-mono">{{ $voucher->code }}</div>
                                        <div class="text-xs text-gray-500">
                                            {{ $voucher->valid_until ? 'Exp: ' . $voucher->valid_until->format('d M Y') : 'No Expiry' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-brand-yellow font-bold">
                                            @if($voucher->discount_type == 'fixed')
                                                Rp {{ number_format($voucher->amount, 0, ',', '.') }}
                                            @else
                                                {{ $voucher->amount }}%
                                            @endif
                                        </div>
                                        @if($voucher->min_purchase)
                                            <div class="text-xs text-gray-500">Min: {{ number_format($voucher->min_purchase) }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-gray-300">
                                        {{ $voucher->used_count }} / {{ $voucher->usage_limit ?: '∞' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <button wire:click="toggleActive({{ $voucher->id }})" 
                                            class="px-3 py-1 rounded-full text-xs font-bold border transition-all {{ $voucher->is_active && $voucher->isValid() ? 'bg-green-500/10 text-green-500 border-green-500/20' : 'bg-red-500/10 text-red-500 border-red-500/20' }}">
                                            {{ $voucher->is_active ? 'ACTIVE' : 'INACTIVE' }}
                                        </button>
                                    </td>
                                    <td class="px-6 py-4 text-right space-x-2">
                                        <button wire:click="edit({{ $voucher->id }})" class="p-2 text-blue-400 hover:text-white transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                        </button>
                                        <button 
                                            @click="$dispatch('confirm-action', { 
                                                event: 'delete', 
                                                params: { id: {{ $voucher->id }} },
                                                title: 'Hapus Voucher?',
                                                text: 'Voucher ini akan dihapus permanen!',
                                                icon: 'warning',
                                                confirmButtonColor: '#EF4444',
                                                confirmText: 'Ya, Hapus!'
                                            })"
                                            class="p-2 text-red-500 hover:text-white transition-colors"
                                        >
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2.001 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-gray-700/50">
                    {{ $vouchers->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

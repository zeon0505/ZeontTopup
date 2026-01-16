<div>
    <!-- Header -->
    <div class="mb-8 flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h2 class="text-3xl font-black text-white tracking-tight">Payment Methods</h2>
            <p class="mt-1 text-sm text-gray-400">Manage payment channels, icons, and fees.</p>
        </div>
        <button wire:click="create" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-indigo-500/20 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Add Payment Method
        </button>
    </div>

    <!-- Table Card -->
    <div class="bg-dark-800 border border-gray-700/50 rounded-2xl overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-700/50 text-left">
                <thead class="bg-dark-900/50">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Icon</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Code</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Fee</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700/50 bg-dark-800">
                    @forelse($methods as $method)
                        <tr class="hover:bg-dark-900/50 transition-colors duration-150 group">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="w-12 h-8 bg-white rounded flex items-center justify-center p-1 overflow-hidden">
                                    @if($method->icon)
                                        <img src="{{ asset($method->icon) }}" class="h-full object-contain">
                                    @else
                                        <span class="text-[8px] font-bold text-black">{{ substr($method->code, 0, 3) }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-white">{{ $method->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-mono bg-gray-700 rounded text-gray-300">{{ $method->code }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-bold bg-indigo-900/30 text-indigo-400 rounded-full border border-indigo-500/20">
                                    {{ $method->category }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                Rp {{ number_format($method->fee, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button wire:click="toggleStatus('{{ $method->id }}')" class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-900 {{ $method->is_active ? 'bg-green-500' : 'bg-gray-700' }}">
                                    <span class="sr-only">Toggle status</span>
                                    <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform {{ $method->is_active ? 'translate-x-6' : 'translate-x-1' }}"></span>
                                </button>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="edit('{{ $method->id }}')" class="text-indigo-400 hover:text-indigo-300 mr-3 transition-colors">Edit</button>
                                <button wire:click="delete('{{ $method->id }}')" class="text-red-400 hover:text-red-300 transition-colors" onclick="confirm('Are you sure?') || event.stopImmediatePropagation()">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                                No payment methods found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Form -->
    @if($isOpen)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Overlay -->
                <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" wire:click="closeModal"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-dark-800 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full border border-gray-700">
                    <div class="px-6 py-6">
                        <h3 class="text-xl font-bold text-white mb-6" id="modal-title">
                            {{ $isEdit ? 'Edit Payment Method' : 'Add New Payment Method' }}
                        </h3>

                        <form wire:submit="store" class="space-y-4">
                            <!-- Code & Category -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-400 mb-1">Code</label>
                                    <input type="text" wire:model="code" class="w-full bg-dark-900 border border-gray-700 rounded-lg px-4 py-2 text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 uppercase" placeholder="e.g. QRIS">
                                    @error('code') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-400 mb-1">Category</label>
                                    <select wire:model="category" class="w-full bg-dark-900 border border-gray-700 rounded-lg px-4 py-2 text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                                        <option value="">Select Category</option>
                                        <option value="E-Wallet">E-Wallet</option>
                                        <option value="Virtual Account">Virtual Account</option>
                                        <option value="Convenience Store">Convenience Store</option>
                                        <option value="Credit Card">Credit Card</option>
                                    </select>
                                    @error('category') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-1">Name</label>
                                <input type="text" wire:model="name" class="w-full bg-dark-900 border border-gray-700 rounded-lg px-4 py-2 text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500" placeholder="e.g. QRIS (All Payment)">
                                @error('name') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- Icon Upload -->
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-1">Icon</label>
                                <div class="flex items-center gap-4">
                                    @if($newIcon)
                                        <img src="{{ $newIcon->temporaryUrl() }}" class="w-16 h-10 object-contain bg-white rounded p-1">
                                    @elseif($icon)
                                        <img src="{{ asset($icon) }}" class="w-16 h-10 object-contain bg-white rounded p-1">
                                    @endif
                                    
                                    <input type="file" wire:model="newIcon" class="block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-gray-700 file:text-white hover:file:bg-gray-600">
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Leave empty to keep existing icon.</p>
                                @error('newIcon') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- Fee -->
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-1">Admin Fee</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">Rp</span>
                                    <input type="number" wire:model="fee" class="w-full bg-dark-900 border border-gray-700 rounded-lg pl-10 pr-4 py-2 text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500" placeholder="0">
                                </div>
                                @error('fee') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- Status -->
                            <div class="flex items-center gap-2">
                                <input type="checkbox" wire:model="is_active" id="is_active" class="w-4 h-4 rounded border-gray-700 bg-dark-900 text-indigo-600 focus:ring-indigo-500">
                                <label for="is_active" class="text-sm font-medium text-white">Active Status</label>
                            </div>

                            <!-- Actions -->
                            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-700">
                                <button type="button" wire:click="closeModal" class="px-4 py-2 text-gray-400 hover:text-white transition-colors font-medium">Cancel</button>
                                <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow-lg shadow-indigo-500/20 transition-all">
                                    {{ $isEdit ? 'Update Method' : 'Create Method' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

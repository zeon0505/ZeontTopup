<div>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-white">API Configurations</h2>
        <button wire:click="openCreateModal" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors">
            Add New Provider
        </button>
    </div>
    
    <div class="mb-6 p-4 bg-blue-500/10 border border-blue-500/20 rounded-lg">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-blue-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <h4 class="text-sm font-semibold text-blue-400">About API Settings</h4>
                <p class="text-sm text-gray-400 mt-1">
                    Manage API keys and endpoints for third-party providers (e.g., Digiflazz, VIP Reseller, Apigames). 
                    These credentials are used to automatically process orders.
                </p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($apis as $api)
        <div class="bg-dark-800 rounded-xl border border-gray-700 p-6 hover:border-indigo-500 transition-colors">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-lg font-bold text-white">{{ $api->provider_name }}</h3>
                    <span class="text-xs px-2 py-1 rounded-full {{ $api->is_active ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">
                        {{ $api->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
                <div class="flex gap-2">
                    <button wire:click="openEditModal({{ $api->id }})" class="p-2 text-gray-400 hover:text-indigo-400 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </button>
                    <button wire:confirm="Are you sure?" wire:click="delete({{ $api->id }})" class="p-2 text-gray-400 hover:text-red-400 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </div>
            </div>
            
            <div class="space-y-3">
                <div>
                    <label class="text-xs text-gray-500 uppercase">Endpoint</label>
                    <p class="text-sm text-gray-300 truncate" title="{{ $api->endpoint }}">{{ $api->endpoint ?: '-' }}</p>
                </div>
                <div>
                    <label class="text-xs text-gray-500 uppercase">API Key</label>
                    <p class="text-sm text-gray-300 font-mono truncate">
                        {{ $api->api_key ? Str::mask($api->api_key, '*', 4, -4) : '-' }}
                    </p>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12 bg-dark-800 rounded-xl border border-gray-700 border-dashed">
            <p class="text-gray-500">No API configurations found.</p>
        </div>
        @endforelse
    </div>

    <!-- Modal -->
    @if($showModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="bg-dark-800 rounded-xl border border-gray-700 w-full max-w-lg p-6 shadow-2xl">
            <h3 class="text-xl font-bold text-white mb-4">{{ $editingId ? 'Edit Provider' : 'Add New Provider' }}</h3>
            
            <form wire:submit="save" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">Provider Name</label>
                    <input type="text" wire:model="provider_name" class="w-full bg-dark-900 border border-gray-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-indigo-500">
                    @error('provider_name') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">Endpoint URL</label>
                    <input type="url" wire:model="endpoint" class="w-full bg-dark-900 border border-gray-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-indigo-500">
                    @error('endpoint') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">API Key</label>
                    <input type="text" wire:model="api_key" class="w-full bg-dark-900 border border-gray-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-indigo-500">
                    @error('api_key') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">API Secret</label>
                    <input type="password" wire:model="api_secret" class="w-full bg-dark-900 border border-gray-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-indigo-500">
                    @error('api_secret') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center pt-2">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" wire:model="is_active" class="w-4 h-4 rounded border-gray-700 text-indigo-600 focus:ring-indigo-500 bg-dark-900">
                        <span class="text-sm text-gray-300">Active</span>
                    </label>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" wire:click="$set('showModal', false)" class="px-4 py-2 text-gray-400 hover:text-white transition-colors">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors">
                        {{ $editingId ? 'Update Provider' : 'Create Provider' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>

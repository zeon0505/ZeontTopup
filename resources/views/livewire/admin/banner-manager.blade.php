<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-white">Banner Sliders</h1>
            <p class="text-gray-400">Manage homepage banner images and texts</p>
        </div>
        <button wire:click="create" class="px-4 py-2 bg-brand-yellow text-black font-bold rounded-lg hover:bg-yellow-400 transition-colors">
            + Add New Banner
        </button>
    </div>

    <!-- Banner List -->
    <div class="bg-gray-800 rounded-xl border border-gray-700 overflow-hidden">
        <table class="w-full text-left text-gray-300">
            <thead class="bg-gray-700/50">
                <tr>
                    <th class="px-6 py-4 font-bold text-white">Image</th>
                    <th class="px-6 py-4 font-bold text-white">Title</th>
                    <th class="px-6 py-4 font-bold text-white">Order</th>
                    <th class="px-6 py-4 font-bold text-white">Status</th>
                    <th class="px-6 py-4 font-bold text-white text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @forelse($banners as $banner)
                <tr class="hover:bg-gray-700/30 transition-colors">
                    <td class="px-6 py-4">
                        <img src="{{ Storage::url($banner->image) }}" class="w-32 h-16 object-cover rounded-lg bg-gray-900" alt="Banner">
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-white">{{ $banner->title }}</div>
                        <div class="text-xs text-gray-500 truncate max-w-xs">{{ $banner->description }}</div>
                    </td>
                    <td class="px-6 py-4 font-mono">
                        {{ $banner->sort_order }}
                    </td>
                    <td class="px-6 py-4">
                        <button wire:click="toggleStatus({{ $banner->id }})" 
                            class="px-2 py-1 text-xs font-bold rounded-full {{ $banner->is_active ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">
                            {{ $banner->is_active ? 'Active' : 'Inactive' }}
                        </button>
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <button wire:click="edit({{ $banner->id }})" class="text-indigo-400 hover:text-indigo-300">Edit</button>
                        <button wire:click="confirmDelete({{ $banner->id }})" class="text-red-400 hover:text-red-300">Delete</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                        No banners found. Click "Add New Banner" to create one.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal Form -->
    @if($showModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" wire:click="$set('showModal', false)"></div>

            <div class="inline-block align-bottom bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full border border-gray-700">
                <div class="px-4 pt-5 pb-4 sm:p-6 p-6">
                    <h3 class="text-lg leading-6 font-medium text-white mb-4">
                        {{ $isEditing ? 'Edit Banner' : 'Create New Banner' }}
                    </h3>

                    <div class="space-y-4">
                        <!-- Image Upload -->
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1">Banner Image (Recomm. 1200x400)</label>
                            @if ($image)
                                <img src="{{ $image->temporaryUrl() }}" class="w-full h-32 object-cover rounded-lg mb-2">
                            @elseif($currentImage)
                                <img src="{{ Storage::url($currentImage) }}" class="w-full h-32 object-cover rounded-lg mb-2">
                            @endif
                            
                            <input type="file" wire:model="image" class="block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-brand-yellow file:text-black hover:file:bg-yellow-400"/>
                            @error('image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Title -->
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1">Title</label>
                            <input type="text" wire:model="title" class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2 text-white focus:border-brand-yellow focus:ring-1 focus:ring-brand-yellow">
                            @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1">Description</label>
                            <textarea wire:model="description" rows="2" class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2 text-white focus:border-brand-yellow focus:ring-1 focus:ring-brand-yellow"></textarea>
                        </div>
                        
                         <!-- Button Text -->
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1">Button Text (Optional)</label>
                            <input type="text" wire:model="button_text" placeholder="e.g. Order Now" class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2 text-white focus:border-brand-yellow focus:ring-1 focus:ring-brand-yellow">
                        </div>
                        
                          <!-- Button URL -->
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1">Button URL (Optional)</label>
                            <input type="text" wire:model="button_url" placeholder="e.g. /games" class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2 text-white focus:border-brand-yellow focus:ring-1 focus:ring-brand-yellow">
                        </div>

                        <div class="flex gap-4">
                            <!-- Sort Order -->
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-400 mb-1">Sort Order</label>
                                <input type="number" wire:model="sort_order" class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2 text-white focus:border-brand-yellow focus:ring-1 focus:ring-brand-yellow">
                            </div>
                            
                            <!-- Active Status -->
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-400 mb-1">Status</label>
                                <select wire:model="is_active" class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2 text-white focus:border-brand-yellow focus:ring-1 focus:ring-brand-yellow">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-800 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-700">
                    <button wire:click="{{ $isEditing ? 'update' : 'store' }}" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-brand-yellow text-base font-medium text-black hover:bg-yellow-400 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        {{ $isEditing ? 'Update Banner' : 'Save Banner' }}
                    </button>
                    <button wire:click="$set('showModal', false)" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-600 shadow-sm px-4 py-2 bg-gray-700 text-base font-medium text-gray-300 hover:bg-gray-600 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if($confirmingDeletion)
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" wire:click="$set('confirmingDeletion', false)"></div>
            <div class="inline-block align-bottom bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full border border-gray-700">
                <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-white">Delete Banner</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-400">Are you sure you want to delete this banner? This action cannot be undone.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-800 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-700">
                    <button wire:click="delete" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Delete
                    </button>
                    <button wire:click="$set('confirmingDeletion', false)" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-600 shadow-sm px-4 py-2 bg-gray-700 text-base font-medium text-gray-300 hover:bg-gray-600 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

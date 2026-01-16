<div>
    <!-- Header -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="text-3xl font-black text-white tracking-tight">User Management</h2>
                <p class="mt-1 text-sm text-gray-400">Manage registered users and administrators</p>
            </div>
            <button wire:click="openCreateModal" 
                class="group relative inline-flex items-center justify-center px-6 py-3 text-sm font-bold text-white transition-all duration-200 bg-indigo-600 font-pj rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 hover:bg-indigo-700">
                <div class="absolute -inset-2 rounded-xl bg-indigo-600/20 opacity-0 group-hover:opacity-100 transition-opacity duration-200 blur-lg"></div>
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Add New User
            </button>
        </div>
    </div>

    <!-- Content Card -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-dark-800 border border-gray-700/50 rounded-2xl overflow-hidden shadow-xl">
            <!-- Search -->
            <div class="p-6 border-b border-gray-700/50">
                <div class="max-w-lg relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input 
                        wire:model.live="searchTerm" 
                        type="text" 
                        placeholder="Search users by name or email..." 
                        class="block w-full pl-10 pr-3 py-2.5 border border-gray-700 rounded-xl leading-5 bg-dark-900 text-gray-300 placeholder-gray-500 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 sm:text-sm transition-colors duration-200"
                    >
                </div>
            </div>

            <!-- Users Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-700/50 text-left">
                    <thead class="bg-dark-900/50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">User Info</th>
                            <th scope="col" class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Email Stats</th>
                            <th scope="col" class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Orders</th>
                            <th scope="col" class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Joined</th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700/50 bg-dark-800">
                        @foreach($users as $user)
                            <tr class="hover:bg-dark-900/50 transition-colors duration-150 group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 rounded-full bg-indigo-500/20 flex items-center justify-center text-indigo-400 font-bold border border-indigo-500/30">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-white group-hover:text-indigo-400 transition-colors">{{ $user->name }}</div>
                                            <div class="text-xs text-gray-500">
                                                @if($user->is_admin)
                                                    <span class="text-brand-yellow font-bold">Administrator</span>
                                                @else
                                                    User
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-300">{{ $user->email }}</div>
                                    <div class="text-xs text-green-400 flex items-center mt-1">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Verified
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-700 text-gray-300">
                                        {{ $user->orders_count }} Orders
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-400">{{ $user->created_at->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-600">{{ $user->created_at->diffForHumans() }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                        <button 
                                            type="button"
                                            x-on:click="$wire.openEditModal('{{ $user->id }}')"
                                            class="p-2 text-indigo-400 hover:text-white hover:bg-indigo-600 rounded-lg transition-all duration-200"
                                            title="Edit User">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </button>
                                        <button 
                                            type="button"
                                            x-on:click="Swal.fire({
                                                title: 'Delete User?',
                                                text: 'This action cannot be undone!',
                                                icon: 'warning',
                                                background: '#1E293B',
                                                color: '#fff',
                                                showCancelButton: true,
                                                confirmButtonColor: '#EF4444',
                                                cancelButtonColor: '#64748B',
                                                confirmButtonText: 'Yes, Delete!'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    $wire.delete('{{ $user->id }}')
                                                }
                                            })"
                                            class="p-2 text-red-400 hover:text-white hover:bg-red-600 rounded-lg transition-all duration-200"
                                            title="Delete User">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-700/50 bg-dark-900/30">
                {{ $users->links() }}
            </div>
        </div>
    </div>

    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" wire:click="closeModal">
            <div class="w-full max-w-md p-6 bg-gray-800 rounded-xl" wire:click.stop>
                <h3 class="mb-4 text-xl font-bold text-white">{{ $editingUserId ? 'Edit User' : 'Add New User' }}</h3>
                
                <form wire:submit.prevent="save" class="space-y-4">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-300">Name</label>
                        <input wire:model="name" type="text" class="w-full px-4 py-2 text-white bg-gray-900 border border-gray-700 rounded-lg">
                        @error('name') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-300">Email</label>
                        <input wire:model="email" type="email" class="w-full px-4 py-2 text-white bg-gray-900 border border-gray-700 rounded-lg">
                        @error('email') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-300">Password {{ $editingUserId ? '(leave blank to keep current)' : '' }}</label>
                        <input wire:model="password" type="password" class="w-full px-4 py-2 text-white bg-gray-900 border border-gray-700 rounded-lg">
                        @error('password') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end gap-3 pt-4">
                        <button type="button" wire:click="closeModal" class="px-4 py-2 text-gray-300 bg-gray-700 rounded-lg hover:bg-gray-600">
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

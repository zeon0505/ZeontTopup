<div class="p-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-black text-white uppercase tracking-tight">Review Moderation</h1>
            <p class="text-sm text-gray-400 mt-1">Manage and moderate game reviews from users.</p>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="relative">
            <input wire:model.live="search" type="text" placeholder="Search user, game, or comment..." 
                   class="w-full pl-10 pr-4 py-2.5 bg-dark-800 border border-gray-700/50 rounded-xl text-sm text-white focus:outline-none focus:border-brand-yellow transition-all">
            <svg class="absolute left-3 top-3 w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>

        <select wire:model.live="filterStatus" class="bg-dark-800 border border-gray-700/50 text-white text-sm rounded-xl focus:ring-brand-yellow focus:border-brand-yellow block w-full p-2.5 outline-none transition-all">
            <option value="all">All Status</option>
            <option value="approved">Approved</option>
            <option value="pending">Pending</option>
        </select>

        <select wire:model.live="filterRating" class="bg-dark-800 border border-gray-700/50 text-white text-sm rounded-xl focus:ring-brand-yellow focus:border-brand-yellow block w-full p-2.5 outline-none transition-all">
            <option value="all">All Ratings</option>
            <option value="5">5 Stars</option>
            <option value="4">4 Stars</option>
            <option value="3">3 Stars</option>
            <option value="2">2 Stars</option>
            <option value="1">1 Star</option>
        </select>

        <select wire:model.live="filterGame" class="bg-dark-800 border border-gray-700/50 text-white text-sm rounded-xl focus:ring-brand-yellow focus:border-brand-yellow block w-full p-2.5 outline-none transition-all">
            <option value="all">All Games</option>
            @foreach($games as $game)
                <option value="{{ $game->id }}">{{ $game->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- table -->
    <div class="bg-dark-800 rounded-2xl border border-gray-700/50 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-400">
                <thead class="text-xs text-gray-500 uppercase bg-dark-700/50 border-b border-gray-700/50">
                    <tr>
                        <th class="px-6 py-4 font-bold">User</th>
                        <th class="px-6 py-4 font-bold">Game</th>
                        <th class="px-6 py-4 font-bold">Rating</th>
                        <th class="px-6 py-4 font-bold">Comment</th>
                        <th class="px-6 py-4 font-bold">Status</th>
                        <th class="px-6 py-4 font-bold">Date</th>
                        <th class="px-6 py-4 font-bold text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700/50">
                    @forelse($reviews as $review)
                        <tr class="hover:bg-dark-700/30 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold text-xs uppercase overflow-hidden">
                                        @if($review->user->avatar)
                                            <img src="{{ Storage::url($review->user->avatar) }}" class="w-full h-full object-cover">
                                        @else
                                            {{ substr($review->user->name, 0, 2) }}
                                        @endif
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-white font-medium">{{ $review->user->name }}</span>
                                        <span class="text-[10px] text-gray-500 uppercase tracking-wider">{{ $review->user->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-white">
                                {{ $review->game->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex text-yellow-400">
                                    @for($i=1; $i<=5; $i++)
                                        <svg class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'fill-current' : 'text-gray-600 fill-current opacity-20' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    @endfor
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-gray-300 line-clamp-2 max-w-md italic">
                                    "{{ $review->comment ?? 'No comment provided.' }}"
                                </p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($review->is_approved)
                                    <span class="bg-green-500/10 text-green-500 text-[10px] font-bold px-2.5 py-1 rounded-full border border-green-500/20 uppercase">Approved</span>
                                @else
                                    <span class="bg-yellow-500/10 text-yellow-500 text-[10px] font-bold px-2.5 py-1 rounded-full border border-yellow-500/20 uppercase">Pending</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">
                                {{ $review->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end gap-2">
                                    <button wire:click="toggleApproval('{{ $review->id }}')" 
                                            class="p-2 rounded-lg transition-all {{ $review->is_approved ? 'bg-yellow-500/10 text-yellow-500 hover:bg-yellow-500/20' : 'bg-green-500/10 text-green-500 hover:bg-green-500/20' }}" 
                                            title="{{ $review->is_approved ? 'Reject Review' : 'Approve Review' }}">
                                        @if($review->is_approved)
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        @else
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        @endif
                                    </button>
                                    <button wire:click="deleteReview('{{ $review->id }}')" 
                                            wire:confirm="Are you sure you want to delete this review permanently?"
                                            class="p-2 bg-red-500/10 text-red-500 rounded-lg hover:bg-red-500/20 transition-all"
                                            title="Delete Review">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-700 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    <span class="text-sm">No reviews found matching your criteria.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($reviews->hasPages())
            <div class="px-6 py-4 bg-dark-700/30 border-t border-gray-700/50">
                {{ $reviews->links() }}
            </div>
        @endif
    </div>
</div>

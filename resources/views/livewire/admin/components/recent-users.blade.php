<div class="bg-dark-800 p-6 rounded-2xl border border-gray-700/50 shadow-xl h-full">
    <h3 class="text-lg font-bold text-white mb-6 flex items-center gap-2">
        <span class="bg-blue-500/10 p-1.5 rounded-lg">
            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
        </span>
        New Members
    </h3>

    <div class="space-y-4">
        @forelse($recentUsers as $user)
            <div class="flex items-center gap-4 p-3 rounded-xl hover:bg-dark-700/50 transition-colors border border-transparent hover:border-gray-700">
                <div class="w-10 h-10 rounded-full bg-dark-600 flex items-center justify-center text-sm font-bold text-gray-400 overflow-hidden shrink-0">
                    @if($user->avatar)
                         <img src="{{ Storage::url($user->avatar) }}" class="w-full h-full object-cover">
                    @else
                        {{ substr($user->name, 0, 2) }}
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-white truncate">{{ $user->name }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ $user->email }}</p>
                </div>
                <div class="text-xs text-gray-400">
                    {{ $user->created_at->diffForHumans() }}
                </div>
            </div>
        @empty
            <div class="text-center text-gray-500 py-4">
                No new members yet.
            </div>
        @endforelse
    </div>
</div>

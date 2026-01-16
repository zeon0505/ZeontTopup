<div x-data="{ open: false }" class="relative">
    <!-- Notification Bell Button -->
    <button @click="open = !open" class="relative p-2 text-gray-400 hover:text-brand-yellow transition-colors bg-dark-800 rounded-full border border-gray-700 hover:border-brand-yellow/50 group">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        @if($unreadCount > 0)
            <span class="absolute top-0 right-0 flex h-4 w-4">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-yellow opacity-75"></span>
                <span class="relative inline-flex rounded-full h-4 w-4 bg-brand-yellow text-[10px] text-black font-black items-center justify-center border-2 border-dark-900">{{ $unreadCount }}</span>
            </span>
        @endif
    </button>

    <!-- Dropdown Menu -->
    <div x-show="open" @click.away="open = false" 
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="absolute right-0 mt-3 w-80 bg-dark-800 border border-gray-700 rounded-2xl shadow-2xl z-[60] overflow-hidden" 
         style="display: none;">
        
        <div class="px-4 py-3 bg-dark-700/50 border-b border-gray-700 flex items-center justify-between">
            <h3 class="text-xs font-black uppercase tracking-widest text-white">Notifications</h3>
            @if($unreadCount > 0)
                <button wire:click="markAllAsRead" class="text-[10px] text-brand-yellow hover:underline uppercase font-bold">Mark all read</button>
            @endif
        </div>

        <div class="max-h-96 overflow-y-auto no-scrollbar">
            @forelse($notifications as $notification)
                <div class="px-4 py-4 border-b border-gray-700/50 hover:bg-dark-700 transition-colors {{ $notification->read_at ? '' : 'bg-brand-yellow/5' }} cursor-pointer"
                     wire:click="markAsRead('{{ $notification->id }}')">
                    <div class="flex gap-3">
                        <div class="flex-shrink-0 mt-1">
                            @if($notification->data['type'] ?? '' == 'achievement')
                                <div class="w-8 h-8 rounded-lg bg-indigo-500/20 text-indigo-400 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                </div>
                            @elseif($notification->data['type'] ?? '' == 'level_up')
                                <div class="w-8 h-8 rounded-lg bg-brand-yellow/20 text-brand-yellow flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                                </div>
                            @else
                                <div class="w-8 h-8 rounded-lg bg-gray-500/20 text-gray-400 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-bold text-white line-clamp-1 italic">{{ $notification->data['title'] ?? 'Platform Alert' }}</p>
                            <p class="text-xs text-gray-400 line-clamp-2 mt-0.5">{{ $notification->data['message'] ?? 'No message content' }}</p>
                            <p class="text-[10px] text-gray-500 mt-2 font-bold uppercase">{{ $notification->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-4 py-12 text-center">
                    <div class="w-12 h-12 bg-dark-700 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-600">
                         <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                    </div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">No notifications yet</p>
                </div>
            @endforelse
        </div>

        <div class="p-3 bg-dark-700/30 border-t border-gray-700 text-center">
            <a href="#" class="text-[10px] text-gray-400 hover:text-white uppercase font-black tracking-widest transition-colors">View All Activities</a>
        </div>
    </div>
</div>

<div class="min-h-screen py-12 bg-dark-900">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-black text-white uppercase tracking-tight italic">Notifikasi</h1>
                <p class="text-gray-400 text-sm mt-1">Semua aktivitas dan pemberitahuan akun Bapak</p>
            </div>
            @if($notifications->whereNull('read_at')->count() > 0)
                <button wire:click="markAllAsRead" class="px-4 py-2 bg-dark-800 border border-gray-700 hover:border-brand-yellow text-brand-yellow text-xs font-black uppercase tracking-widest rounded-xl transition-all">
                    Tandai Semua Sudah Dibaca
                </button>
            @endif
        </div>

        <!-- Notification List -->
        <div class="space-y-4">
            @forelse($notifications as $notification)
                <div class="group relative overflow-hidden bg-dark-800 border {{ $notification->read_at ? 'border-gray-700/50' : 'border-brand-yellow/30 bg-brand-yellow/5 shadow-[0_0_20px_rgba(250,204,21,0.05)]' }} rounded-2xl p-6 transition-all hover:bg-dark-700/50 cursor-pointer"
                     wire:click="markAsRead('{{ $notification->id }}')">
                    
                    <div class="flex gap-6 items-start">
                        <!-- Icon -->
                        <div class="flex-shrink-0">
                            @php
                                $type = $notification->data['type'] ?? 'info';
                                $bgClass = match($type) {
                                    'achievement' => 'bg-indigo-500/20 text-indigo-400',
                                    'level_up' => 'bg-brand-yellow/20 text-brand-yellow',
                                    'deposit' => 'bg-green-500/20 text-green-400',
                                    'order' => 'bg-red-500/20 text-red-400',
                                    default => 'bg-gray-500/20 text-gray-400'
                                };
                            @endphp
                            <div class="w-12 h-12 rounded-2xl {{ $bgClass }} flex items-center justify-center shadow-lg">
                                @if($type == 'achievement')
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                @elseif($type == 'level_up')
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                                @elseif($type == 'deposit')
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                @else
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                                @endif
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-1">
                                <h3 class="text-lg font-black text-white italic tracking-wide group-hover:text-brand-yellow transition-colors">
                                    {{ $notification->data['title'] ?? 'Platform Alert' }}
                                </h3>
                                <span class="text-xs font-bold text-gray-500 uppercase tracking-widest">{{ $notification->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-gray-400 text-sm leading-relaxed mb-4">{{ $notification->data['message'] ?? '' }}</p>
                            
                            @if(!$notification->read_at)
                                <div class="inline-flex items-center gap-2 px-2 py-0.5 rounded-full bg-brand-yellow/10 border border-brand-yellow/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-brand-yellow animate-pulse"></span>
                                    <span class="text-[10px] font-black text-brand-yellow uppercase tracking-widest">Baru</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Glow Effect -->
                    @if(!$notification->read_at)
                    <div class="absolute -right-12 -top-12 w-32 h-32 bg-brand-yellow/10 blur-3xl rounded-full opacity-50 group-hover:opacity-100 transition-opacity"></div>
                    @endif
                </div>
            @empty
                <div class="bg-dark-800 rounded-3xl p-16 text-center border border-gray-700/50">
                    <div class="w-20 h-20 bg-dark-700 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-600">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                    </div>
                    <h3 class="text-xl font-black text-white uppercase tracking-tight italic mb-2">Hening...</h3>
                    <p class="text-gray-500 max-w-xs mx-auto text-sm font-medium">Belum ada notifikasi baru untuk saat ini. Tetap pantau terus ya Pak!</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $notifications->links() }}
        </div>
    </div>
</div>

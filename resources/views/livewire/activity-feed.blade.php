<div class="bg-dark-800/40 backdrop-blur-xl border border-white/10 rounded-[2rem] overflow-hidden shadow-[0_20px_50px_rgba(0,0,0,0.3)] group/feed">
    <!-- Header -->
    <div class="px-8 py-5 bg-white/5 border-b border-white/5 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="relative flex h-3 w-3">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500 shadow-[0_0_10px_rgba(34,197,94,0.5)]"></span>
            </div>
            <h3 class="text-xs font-black text-white uppercase tracking-[0.2em] italic">Aktivitas Live</h3>
        </div>
        <button wire:click="refreshActivities" class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center text-gray-400 hover:text-brand-yellow hover:bg-white/10 transition-all border border-transparent hover:border-brand-yellow/30">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
        </button>
    </div>

    <!-- Feed Content -->
    <div class="p-3 max-h-[450px] overflow-y-auto no-scrollbar scroll-smooth" id="activity-feed-v2">
        <div class="space-y-2">
            @forelse($activities as $activity)
                <div class="relative px-5 py-4 rounded-2xl bg-white/[0.02] border border-white/[0.05] hover:bg-white/[0.07] hover:border-white/10 transition-all duration-300 group flex items-start gap-4 overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-0.5">
                    <!-- Glow Overlay -->
                    <div class="absolute -right-8 -bottom-8 w-24 h-24 rounded-full opacity-5 blur-2xl group-hover:opacity-20 transition-opacity {{ $activity['type'] == 'order' ? 'bg-brand-yellow' : 'bg-indigo-500' }}"></div>

                    <!-- Icon Container -->
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-transform group-hover:scale-110 shadow-lg {{ $activity['type'] == 'order' ? 'bg-brand-yellow/10 text-brand-yellow border border-brand-yellow/20' : 'bg-indigo-500/10 text-indigo-400 border border-indigo-500/20' }}">
                            @if($activity['icon'] == 'shopping-cart')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                            @else
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                            @endif
                        </div>
                    </div>

                    <!-- Text Info -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-0.5">
                            <span class="text-sm font-black text-white italic tracking-tight truncate">{{ $activity['user'] }}</span>
                            <span class="w-[3px] h-[3px] rounded-full bg-gray-600"></span>
                            <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">{{ \Carbon\Carbon::parse($activity['time'])->diffForHumans(null, true, true) }}</span>
                        </div>
                        <p class="text-[13px] text-gray-400 leading-snug font-medium group-hover:text-gray-300 transition-colors">
                            {!! $activity['message'] !!}
                        </p>
                    </div>
                </div>
            @empty
                <div class="py-12 text-center opacity-40">
                    <div class="w-16 h-16 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-4 border border-dashed border-white/20">
                         <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                    </div>
                    <p class="text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]">Menunggu Aktivitas...</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Footer Status -->
    <div class="px-6 py-4 bg-black/20 border-t border-white/5 flex items-center justify-center gap-3">
         <div class="flex -space-x-2">
            <div class="w-5 h-5 rounded-full border-2 border-dark-900 bg-gray-700 overflow-hidden text-[8px] flex items-center justify-center font-bold">A</div>
            <div class="w-5 h-5 rounded-full border-2 border-dark-900 bg-brand-yellow overflow-hidden text-[8px] flex items-center justify-center font-bold text-black">B</div>
            <div class="w-5 h-5 rounded-full border-2 border-dark-900 bg-indigo-500 overflow-hidden text-[8px] flex items-center justify-center font-bold">C</div>
         </div>
         <span class="text-[9px] font-black text-gray-500 uppercase tracking-[0.15em]">Terhubung dengan 2k+ Users</span>
    </div>
</div>

<div class="bg-dark-800/50 backdrop-blur-xl border border-white/10 rounded-2xl p-6 shadow-2xl overflow-hidden relative group">
    <!-- Background Glow -->
    <div class="absolute -top-24 -right-24 w-48 h-48 bg-brand-yellow/10 rounded-full blur-[80px] group-hover:bg-brand-yellow/20 transition-colors"></div>
    
    <div class="flex items-center justify-between mb-4 relative z-10">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-brand-yellow/20 flex items-center justify-center text-brand-yellow border border-brand-yellow/30 shadow-[0_0_15px_rgba(250,204,21,0.2)] group-hover:scale-110 transition-transform">
                <span class="text-xl font-black italic">{{ $level }}</span>
            </div>
            <div>
                <h3 class="text-white font-black italic text-lg tracking-tight uppercase">User Level</h3>
                <p class="text-gray-400 text-xs font-bold uppercase tracking-widest">Master Voyager</p>
            </div>
        </div>
        <div class="text-right">
            <span class="text-brand-yellow font-black text-xs uppercase tracking-widest">XP: {{ number_format($xp) }} / {{ number_format($nextLevelXp) }}</span>
        </div>
    </div>

    <!-- Progress Bar -->
    <div class="relative h-3 bg-dark-900/50 rounded-full overflow-hidden border border-white/5 p-[1px]">
        <div 
            class="h-full bg-gradient-to-r from-brand-yellow via-yellow-400 to-brand-yellow rounded-full transition-all duration-1000 shadow-[0_0_15px_rgba(250,204,21,0.5)]" 
            style="width: {{ $xpPercentage }}%"
        >
            <div class="w-full h-full animate-progress-shine bg-active-shine opacity-30"></div>
        </div>
    </div>
    
    <div class="mt-4 flex justify-between items-center text-[10px] font-bold uppercase tracking-widest text-gray-500">
        <span>Level {{ $level }}</span>
        <span>Level {{ $level + 1 }}</span>
    </div>

    <style>
        @keyframes progress-shine {
            from { transform: translateX(-100%); }
            to { transform: translateX(100%); }
        }
        .animate-progress-shine {
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            animation: progress-shine 2s infinite linear;
        }
    </style>
</div>

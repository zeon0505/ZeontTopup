<div class="bg-dark-800 rounded-3xl border border-gray-700/50 overflow-hidden shadow-xl relative group">
    <div class="p-6">
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-brand-yellow/10 flex items-center justify-center text-brand-yellow border border-brand-yellow/20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-1.006 3.42 3.42 0 011.666 0 3.42 3.42 0 001.946 1.006 3.42 3.42 0 010 1.666 3.42 3.42 0 001.006 1.946 3.42 3.42 0 010 1.666 3.42 3.42 0 00-1.006 1.946 3.42 3.42 0 01-1.666 0 3.42 3.42 0 00-1.946-1.006 3.42 3.42 0 01-1.666 0 3.42 3.42 0 00-1.946 1.006 3.42 3.42 0 010-1.666 3.42 3.42 0 00-1.006-1.946 3.42 3.42 0 010-1.666 3.42 3.42 0 001.006-1.946 3.42 3.42 0 011.666 0 3.42 3.42 0 001.946 1.006z"/></svg>
                </div>
                <div>
                    <h3 class="text-white font-bold italic uppercase tracking-wider text-sm">BADGE & ACHIEVEMENT</h3>
                    <p class="text-[10px] text-gray-400 font-medium">Koleksi medali kehormatan kamu!</p>
                </div>
            </div>
            
            <div class="text-xs font-black text-brand-yellow bg-brand-yellow/10 px-3 py-1 rounded-full border border-brand-yellow/20">
                {{ $achievements->count() }} Terkumpul
            </div>
        </div>

        @if($achievements->isEmpty())
            <div class="flex flex-col items-center justify-center py-8 text-center bg-dark-900/50 rounded-2xl border border-dashed border-gray-700">
                 <div class="text-3xl grayscale opacity-30 mb-4">🏆</div>
                 <p class="text-xs text-gray-500 font-bold uppercase tracking-widest">Belum ada medal yang diraih</p>
                 <p class="text-[10px] text-gray-600 mt-1 italic">Ayo aktif transaksi dan absen untuk dapat medal!</p>
            </div>
        @else
            <div class="flex flex-wrap gap-4">
                @foreach($achievements as $achievement)
                    <div x-data="{ open: false }" class="relative">
                        <div @mouseenter="open = true" @mouseleave="open = false" 
                             class="w-16 h-16 rounded-full bg-gradient-to-br from-brand-yellow to-yellow-600 flex items-center justify-center text-black text-2xl shadow-[0_0_20px_rgba(250,204,21,0.3)] border-2 border-white/20 transform hover:scale-110 transition-all cursor-pointer group/badge">
                            <i class="{{ $achievement->icon }}"></i>
                            <div class="absolute inset-x-0 bottom-0 flex justify-center translate-y-2 opacity-0 group-hover/badge:opacity-100 transition-opacity">
                                <div class="bg-black text-white text-[8px] font-black px-1.5 py-0.5 rounded shadow-lg uppercase">EARNED</div>
                            </div>
                        </div>

                        <!-- Tooltip -->
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="absolute z-[100] bottom-full left-1/2 -translate-x-1/2 mb-4 w-48 bg-dark-800 border border-brand-yellow/30 p-4 rounded-2xl shadow-2xl pointer-events-none">
                            <div class="text-brand-yellow font-black italic text-xs uppercase mb-1">{{ $achievement->name }}</div>
                            <div class="text-gray-300 text-[10px] leading-relaxed mb-2">{{ $achievement->description }}</div>
                            <div class="text-[9px] text-gray-500 font-bold uppercase tracking-widest flex justify-between">
                                <span>Tercapai pada:</span>
                                <span>{{ $achievement->pivot->achieved_at->format('d/m/y') }}</span>
                            </div>
                            <!-- Arrow -->
                            <div class="absolute top-full left-1/2 -translate-x-1/2 w-3 h-3 bg-dark-800 border-r border-b border-brand-yellow/30 rotate-45 -mt-1.5"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

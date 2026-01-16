<div class="bg-dark-800 rounded-3xl border border-gray-700/50 overflow-hidden shadow-xl relative group">
    <!-- Background Decor -->
    <div class="absolute -top-12 -right-12 w-32 h-32 bg-brand-yellow/10 rounded-full blur-3xl group-hover:bg-brand-yellow/20 transition-all duration-700"></div>

    <div class="p-6 relative z-10">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-brand-yellow/10 flex items-center justify-center text-brand-yellow border border-brand-yellow/20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <h3 class="text-white font-bold italic uppercase tracking-wider text-sm">ABSEN HARIAN</h3>
                    <p class="text-[10px] text-gray-400 font-medium">Ambil reward harian kamu!</p>
                </div>
            </div>
            
            <div class="flex items-center gap-2">
                <span class="text-[10px] font-black text-brand-yellow uppercase tracking-widest bg-brand-yellow/10 px-2 py-1 rounded-lg border border-brand-yellow/20">
                    STREAK: {{ $streak }} 🔥
                </span>
            </div>
        </div>

        @if(session()->has('checkin_success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
                 class="mb-4 p-3 bg-green-500/10 border border-green-500/20 rounded-2xl text-green-500 text-xs font-bold text-center animate-bounce">
                {{ session('checkin_success') }}
            </div>
        @endif

        <div class="bg-dark-900 rounded-2xl p-4 border border-white/5 mb-6">
            <div class="flex items-center justify-between">
                <div class="text-xs text-gray-400">Reward Berikutnya:</div>
                <div class="flex items-center gap-1.5">
                    <span class="text-brand-yellow font-black italic">{{ $nextReward }}</span>
                    <span class="text-[10px] text-gray-500 font-bold uppercase tracking-tighter">Loyalty Points</span>
                </div>
            </div>
            
            <!-- Progress indicator (Visual only for now) -->
            <div class="mt-3 flex gap-1.5 h-1.5">
                @for($i = 1; $i <= 7; $i++)
                    <div class="flex-1 rounded-full {{ $streak >= $i ? 'bg-brand-yellow shadow-[0_0_10px_rgba(250,204,21,0.5)]' : 'bg-gray-700' }}"></div>
                @endfor
            </div>
            <div class="mt-2 text-[8px] text-gray-500 text-center uppercase tracking-widest font-bold">Bonus poin bertambah tiap streak!</div>
        </div>

        @if(!$hasCheckedIn)
            <button wire:click="checkIn" 
                    class="w-full py-4 bg-brand-yellow text-black font-black italic uppercase tracking-wider rounded-2xl hover:bg-yellow-400 transition-all shadow-xl shadow-yellow-500/20 active:scale-95 transform flex items-center justify-center gap-2 group/btn">
                <span>ABSEN SEKARANG</span>
                <svg class="w-5 h-5 transform group-hover/btn:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </button>
        @else
            <button disabled 
                    class="w-full py-4 bg-gray-700 text-gray-400 font-black italic uppercase tracking-wider rounded-2xl cursor-not-allowed flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                SUDAH ABSEN HARI INI
            </button>
        @endif
    </div>
</div>

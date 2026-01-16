
    <div class="py-12 bg-slate-900 min-h-screen relative overflow-hidden" x-data="{ activeTab: 'sultan' }">
        <!-- Background Accents -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
            <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] bg-brand-yellow/5 blurred-circle"></div>
            <div class="absolute bottom-[10%] right-[5%] w-[30%] h-[30%] bg-indigo-500/5 blurred-circle"></div>
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 pt-12">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl md:text-5xl font-extrabold text-white italic mb-2 tracking-tight uppercase">
                    ZEONGAME <span class="text-brand-yellow">LEADERBOARD</span> 🏆
                </h1>
                <p class="text-lg text-gray-400 italic">Penghargaan untuk para pendukung setia ZeonGame.</p>
            </div>

            <!-- Tab Switcher -->
            <div class="flex justify-center gap-4 mb-12">
                <button @click="activeTab = 'sultan'" 
                        :class="activeTab === 'sultan' ? 'bg-brand-yellow text-black shadow-[0_0_20px_rgba(250,204,21,0.3)]' : 'bg-dark-800 text-gray-400 border border-gray-700'" 
                        class="px-8 py-3 rounded-2xl font-black italic transition-all transform active:scale-95">
                    TOP SULTAN 👑
                </button>
                <button @click="activeTab = 'referrer'" 
                        :class="activeTab === 'referrer' ? 'bg-brand-yellow text-black shadow-[0_0_20px_rgba(250,204,21,0.3)]' : 'bg-dark-800 text-gray-400 border border-gray-700'" 
                        class="px-8 py-3 rounded-2xl font-black italic transition-all transform active:scale-95">
                    TOP REFERRER 🤝
                </button>
            </div>
            
            <!-- Sultan List -->
            <div x-show="activeTab === 'sultan'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="bg-dark-800 border border-gray-700/50 rounded-3xl overflow-hidden shadow-2xl backdrop-blur-sm">
                @forelse($topSultans as $index => $user)
                    @php
                        $rank = $index + 1;
                        $medal = match($rank) {
                            1 => '🥇',
                            2 => '🥈',
                            3 => '🥉',
                            default => $rank
                        };
                        
                        $bgColor = match($rank) {
                            1 => 'bg-gradient-to-r from-yellow-500/20 to-transparent border-l-4 border-yellow-500',
                            2 => 'bg-gradient-to-r from-gray-400/20 to-transparent border-l-4 border-gray-400',
                            3 => 'bg-gradient-to-r from-orange-700/20 to-transparent border-l-4 border-orange-700',
                            default => 'hover:bg-dark-900/50 transition-colors border-l-4 border-transparent'
                        };

                        $textColor = match($rank) {
                            1 => 'text-yellow-400',
                            2 => 'text-gray-300',
                            3 => 'text-orange-400',
                            default => 'text-white'
                        };
                    @endphp

                    <div class="flex items-center justify-between p-6 {{ $bgColor }} border-b border-gray-700/30 last:border-0 relative group">
                        <div class="flex items-center gap-6">
                            <div class="w-12 h-12 flex items-center justify-center text-2xl font-black {{ $textColor }}">
                                {{ $medal }}
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full bg-dark-700 border-2 border-gray-600 flex items-center justify-center overflow-hidden">
                                     <span class="text-lg font-bold text-gray-400">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-white group-hover:text-brand-yellow transition-colors">
                                        {{ $user->name }}
                                    </h3>
                                    <p class="text-xs text-gray-400">Total belanja tertinggi</p>
                                </div>
                            </div>
                        </div>

                        <div class="text-right">
                            <p class="text-xs text-gray-500 uppercase tracking-widest mb-1">Spent</p>
                            <p class="text-xl font-black text-brand-yellow">
                                Rp {{ number_format($user->orders_sum_total, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center text-gray-500">Belum ada data.</div>
                @endforelse
            </div>

            <!-- Referrer List -->
            <div x-show="activeTab === 'referrer'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="bg-dark-800 border border-gray-700/50 rounded-3xl overflow-hidden shadow-2xl backdrop-blur-sm">
                @forelse($topReferrers as $index => $user)
                    @php
                        $rank = $index + 1;
                        $medal = match($rank) {
                            1 => '🥇',
                            2 => '🥈',
                            3 => '🥉',
                            default => $rank
                        };
                        
                        $bgColor = match($rank) {
                            1 => 'bg-gradient-to-r from-blue-500/20 to-transparent border-l-4 border-blue-500',
                            2 => 'bg-gradient-to-r from-gray-400/20 to-transparent border-l-4 border-gray-400',
                            3 => 'bg-gradient-to-r from-orange-700/20 to-transparent border-l-4 border-orange-700',
                            default => 'hover:bg-dark-900/50 transition-colors border-l-4 border-transparent'
                        };
                    @endphp

                    <div class="flex items-center justify-between p-6 {{ $bgColor }} border-b border-gray-700/30 last:border-0 relative group">
                        <div class="flex items-center gap-6">
                            <div class="w-12 h-12 flex items-center justify-center text-2xl font-black text-white">
                                {{ $medal }}
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full bg-dark-700 border-2 border-gray-600 flex items-center justify-center overflow-hidden">
                                     <span class="text-lg font-bold text-gray-400">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-white group-hover:text-blue-400 transition-colors">
                                        {{ $user->name }}
                                    </h3>
                                    <p class="text-xs text-gray-400">Marketing Hero ZeonGame</p>
                                </div>
                            </div>
                        </div>

                        <div class="text-right">
                            <p class="text-xs text-gray-500 uppercase tracking-widest mb-1">Referrals</p>
                            <p class="text-xl font-black text-blue-400">
                                {{ $user->referrals_count }} <span class="text-xs font-normal text-gray-400 ml-1">ORANG</span>
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center text-gray-500">Belum ada data referrals.</div>
                @endforelse
            </div>

            <div class="mt-8 text-center">
                <a href="/" class="inline-flex items-center justify-center px-6 py-3 text-sm font-bold text-black transition-all duration-200 bg-brand-yellow rounded-xl hover:bg-yellow-400">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    <style>
        .blurred-circle {
            filter: blur(100px);
            border-radius: 50%;
        }
    </style>
</div>


<div class="py-12 bg-slate-900 min-h-screen relative overflow-hidden" x-data="{ tab: 'winrate' }">
    <!-- Background Accents -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
        <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] bg-brand-yellow/5 blurred-circle"></div>
        <div class="absolute bottom-[10%] right-[5%] w-[30%] h-[30%] bg-indigo-500/5 blurred-circle"></div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 pt-12">
        <div class="text-center mb-10">
            <h1 class="text-3xl lg:text-5xl font-extrabold text-white italic tracking-tight mb-4">GAME <span class="text-brand-yellow">CALCULATOR</span> 🧮</h1>
            <p class="text-gray-400 text-lg">Hitung kebutuhan diamond dan win rate kamu disini.</p>
        </div>

        <!-- Navigation Tabs -->
        <div class="flex justify-center mb-8 gap-4 flex-wrap">
            <button @click="tab = 'winrate'" 
                :class="{ 'bg-brand-yellow text-black border-brand-yellow': tab === 'winrate', 'bg-dark-800 text-gray-400 border-gray-700 hover:text-white': tab !== 'winrate' }"
                class="px-6 py-3 rounded-full font-bold border transition-all duration-300 transform hover:scale-105">
                Win Rate
            </button>
            <button @click="tab = 'magicwheel'" 
                :class="{ 'bg-blue-500 text-white border-blue-500': tab === 'magicwheel', 'bg-dark-800 text-gray-400 border-gray-700 hover:text-white': tab !== 'magicwheel' }"
                class="px-6 py-3 rounded-full font-bold border transition-all duration-300 transform hover:scale-105">
                Magic Wheel
            </button>
            <button @click="tab = 'zodiac'" 
                :class="{ 'bg-purple-500 text-white border-purple-500': tab === 'zodiac', 'bg-dark-800 text-gray-400 border-gray-700 hover:text-white': tab !== 'zodiac' }"
                class="px-6 py-3 rounded-full font-bold border transition-all duration-300 transform hover:scale-105">
                Zodiac
            </button>
        </div>

        <!-- Win Rate Calculator -->
        <div x-show="tab === 'winrate'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
             class="bg-dark-800 rounded-3xl p-8 border border-gray-700/50 shadow-2xl backdrop-blur-sm" x-data="winRateCalc()">
             
            <div class="flex items-center gap-3 mb-6">
                <div class="p-3 bg-brand-yellow/10 rounded-xl text-brand-yellow">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
                <h2 class="text-2xl font-bold text-white">Hitung Win Rate</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Total Pertandingan</label>
                    <input type="number" x-model.number="totalMatches" placeholder="Contoh: 350" class="w-full bg-dark-900 border border-gray-700 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-brand-yellow/50 focus:border-brand-yellow transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Win Rate Saat Ini (%)</label>
                    <input type="number" x-model.number="currentWr" placeholder="Contoh: 48.5" class="w-full bg-dark-900 border border-gray-700 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-brand-yellow/50 focus:border-brand-yellow transition-all">
                </div>
                <div class="md:col-span-2 grid grid-cols-2 gap-4 p-4 bg-dark-900/50 rounded-xl border border-gray-700/50" x-show="totalMatches && currentWr" x-transition>
                    <div class="text-center">
                        <p class="text-xs text-gray-400 mb-1">Total Menang</p>
                        <p class="text-xl font-bold text-green-400" x-text="getWins()">0</p>
                    </div>
                    <div class="text-center">
                        <p class="text-xs text-gray-400 mb-1">Total Kalah</p>
                        <p class="text-xl font-bold text-red-500" x-text="getLosses()">0</p>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-400 mb-2">Target Win Rate (%)</label>
                    <input type="number" x-model.number="targetWr" placeholder="Contoh: 60" class="w-full bg-dark-900 border border-gray-700 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-brand-yellow/50 focus:border-brand-yellow transition-all">
                </div>
            </div>

            <div class="mt-8 p-6 bg-dark-900/50 rounded-2xl border border-dashed border-gray-700 text-center">
                <p class="text-gray-400 mb-2">Kamu perlu menang tanpa kalah sebanyak:</p>
                <h2 class="text-5xl font-black text-brand-yellow mb-2" x-text="calculate()">0</h2>
                <p class="text-sm text-gray-500">Pertandingan</p>
            </div>
        </div>

        <!-- Magic Wheel Calculator -->
        <div x-show="tab === 'magicwheel'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
             class="bg-dark-800 rounded-3xl p-8 border border-gray-700/50 shadow-2xl backdrop-blur-sm" x-data="magicWheelCalc()">
             
            <div class="flex items-center gap-3 mb-6">
                <div class="p-3 bg-blue-500/10 rounded-xl text-blue-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                </div>
                <h2 class="text-2xl font-bold text-white">Magic Wheel Simulator</h2>
            </div>
            
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Magic Point Saat Ini (0-200)</label>
                    <input type="number" x-model.number="currentPoints" max="200" placeholder="0" class="w-full bg-dark-900 border border-gray-700 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all">
                </div>
            </div>

            <div class="mt-8 p-6 bg-dark-900/50 rounded-2xl border border-dashed border-gray-700 text-center">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-400 text-sm mb-1">Kurang Point</p>
                        <h3 class="text-2xl font-bold text-white" x-text="200 - currentPoints">200</h3>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm mb-1">Estimasi Diamond</p>
                        <h3 class="text-2xl font-bold text-blue-400" x-text="calculateDiamonds() + ' 💎'">10800 💎</h3>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-4">*Estimasi maksimal (5 Spin = 270 DM = 5 Point)</p>
            </div>
        </div>

        <!-- Zodiac Calculator -->
        <div x-show="tab === 'zodiac'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
             class="bg-dark-800 rounded-3xl p-8 border border-gray-700/50 shadow-2xl backdrop-blur-sm" x-data="zodiacCalc()">
             
            <div class="flex items-center gap-3 mb-6">
                <div class="p-3 bg-purple-500/10 rounded-xl text-purple-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                </div>
                <h2 class="text-2xl font-bold text-white">Zodiac Summon Simulator</h2>
            </div>
            
             <div class="grid grid-cols-1 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Star Power Saat Ini (0-100)</label>
                    <input type="number" x-model.number="currentPoints" max="100" placeholder="0" class="w-full bg-dark-900 border border-gray-700 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-purple-500/50 focus:border-purple-500 transition-all">
                </div>
            </div>

            <div class="mt-8 p-6 bg-dark-900/50 rounded-2xl border border-dashed border-gray-700 text-center">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-400 text-sm mb-1">Kurang Point</p>
                        <h3 class="text-2xl font-bold text-white" x-text="100 - currentPoints">100</h3>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm mb-1">Estimasi Diamond</p>
                        <h3 class="text-2xl font-bold text-purple-400" x-text="calculateDiamonds() + ' 💎'">2000 💎</h3>
                    </div>
                </div>
                 <p class="text-xs text-gray-500 mt-4">*Estimasi maksimal (5 Spin = 70 DM = 3-5 Point avg)</p>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('alpine:init', () => {
             // Alpine.data definitions here if we moved them out, 
             // but for simple independence we keep functions.
        });

        function winRateCalc() {
            return {
                totalMatches: null,
                currentWr: null,
                targetWr: null,
                getWins() {
                    if (!this.totalMatches || !this.currentWr) return 0;
                    return Math.round(this.totalMatches * (this.currentWr / 100));
                },
                getLosses() {
                    if (!this.totalMatches || !this.currentWr) return 0;
                    return this.totalMatches - this.getWins();
                },
                calculate() {
                    if (!this.totalMatches || !this.currentWr || !this.targetWr) return '-';
                    if (this.targetWr > 100 || this.targetWr < 0) return 'Error';
                    if (this.targetWr <= this.currentWr) return 'Sudah Tercapai';

                    let tTotal = parseFloat(this.totalMatches);
                    let tWin = tTotal * (parseFloat(this.currentWr) / 100);
                    let result = (parseFloat(this.targetWr) * tTotal - 100 * tWin) / (100 - parseFloat(this.targetWr));
                    
                    if (result < 0 || !isFinite(result)) return 'Error';
                    return Math.ceil(result);
                }
            }
        }

        function magicWheelCalc() {
            return {
                currentPoints: 0,
                calculateDiamonds() {
                    let needed = 200 - (this.currentPoints || 0);
                    if (needed <= 0) return 0;
                    return Math.ceil(needed * 54);
                }
            }
        }

        function zodiacCalc() {
            return {
                currentPoints: 0,
                calculateDiamonds() {
                    let needed = 100 - (this.currentPoints || 0);
                    if (needed <= 0) return 0;
                    return Math.ceil(needed * 20);
                }
            }
        }
    </script>
    
    <style>
        .blurred-circle {
            filter: blur(100px);
            border-radius: 50%;
        }
    </style>
</div>

<x-layouts.app>
    <div class="py-12 bg-slate-900 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <h1 class="text-3xl font-extrabold text-white italic">KALKULATOR <span class="text-brand-yellow">WIN RATE</span></h1>
                <p class="mt-2 text-gray-400">Hitung target kemenangan Anda dengan mudah</p>
            </div>

            <div class="bg-slate-800 rounded-2xl p-8 border border-white/10 shadow-xl" x-data="winRateCalc()">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Total Pertandingan</label>
                        <input type="number" x-model.number="totalMatches" class="w-full bg-slate-900 border border-gray-700 text-white rounded-xl px-4 py-3 focus:ring-brand-yellow focus:border-brand-yellow">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Win Rate Saat Ini (%)</label>
                        <input type="number" x-model.number="currentWr" class="w-full bg-slate-900 border border-gray-700 text-white rounded-xl px-4 py-3 focus:ring-brand-yellow focus:border-brand-yellow">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-400 mb-2">Target Win Rate (%)</label>
                        <input type="number" x-model.number="targetWr" class="w-full bg-slate-900 border border-gray-700 text-white rounded-xl px-4 py-3 focus:ring-brand-yellow focus:border-brand-yellow">
                    </div>
                </div>

                <div class="mt-8 p-6 bg-slate-900 rounded-xl border border-dashed border-gray-700 text-center">
                    <p class="text-gray-400 mb-2">Kamu perlu menang sebanyak:</p>
                    <h2 class="text-4xl font-extrabold text-brand-yellow" x-text="calculate()">0</h2>
                    <p class="text-gray-400 mt-2">Tanpa kalah!</p>
                </div>
            </div>

            <script>
                function winRateCalc() {
                    return {
                        totalMatches: 0,
                        currentWr: 0,
                        targetWr: 0,
                        calculate() {
                            if (!this.totalMatches || !this.currentWr || !this.targetWr) return 0;
                            if (this.targetWr > 100) return 'Mustahil!';
                            if (this.targetWr <= this.currentWr) return 0;

                            let tTotal = this.totalMatches;
                            let tWin = (this.totalMatches * (this.currentWr / 100));
                            let mw = 0; // matches wanted

                            // Formula: (TotalWin + MatchesWanted) / (TotalMatch + MatchesWanted) = TargetWR / 100
                            // (tWin + mw) = (TargetWR/100) * (tTotal + mw)
                            // tWin + mw = (target/100)*tTotal + (target/100)*mw
                            // mw - (target/100)*mw = (target/100)*tTotal - tWin
                            // mw * (1 - target/100) = ...

                            let result = (this.targetWr * tTotal - 100 * tWin) / (100 - this.targetWr);
                            return Math.ceil(result);
                        }
                    }
                }
            </script>
        </div>
    </div>
</x-layouts.app>

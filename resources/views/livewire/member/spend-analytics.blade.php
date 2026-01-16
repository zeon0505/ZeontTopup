<div class="space-y-8">
    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-dark-800 border border-gray-700/50 rounded-2xl p-6 relative overflow-hidden group hover:border-brand-yellow/30 transition-all">
            <div class="relative z-10">
                <div class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-2">Total Pengeluaran</div>
                <div class="text-3xl font-black text-white italic">
                    Rp {{ number_format($stats['total_spent'], 0, ',', '.') }}
                </div>
            </div>
            <div class="absolute -right-4 -bottom-4 text-white/5 group-hover:text-brand-yellow/5 transition-colors">
                <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20"><path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"/><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"/></svg>
            </div>
        </div>
        
        <div class="bg-dark-800 border border-gray-700/50 rounded-2xl p-6 relative overflow-hidden group hover:border-brand-yellow/30 transition-all">
            <div class="relative z-10">
                <div class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-2">Bulan Ini</div>
                <div class="text-3xl font-black text-brand-yellow italic">
                    Rp {{ number_format($stats['this_month'], 0, ',', '.') }}
                </div>
            </div>
            <div class="absolute -right-4 -bottom-4 text-white/5 group-hover:text-brand-yellow/5 transition-colors">
                <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/></svg>
            </div>
        </div>

        <div class="bg-dark-800 border border-gray-700/50 rounded-2xl p-6 relative overflow-hidden group hover:border-brand-yellow/30 transition-all">
            <div class="relative z-10">
                <div class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-2">Total Transaksi</div>
                <div class="text-3xl font-black text-white italic">
                    {{ $stats['orders_count'] }} <span class="text-sm font-normal text-gray-500 uppercase">Kali</span>
                </div>
            </div>
            <div class="absolute -right-4 -bottom-4 text-white/5 group-hover:text-brand-yellow/5 transition-colors">
                <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/></svg>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Spend Trend Chart -->
        <div class="bg-dark-800 border border-gray-700/50 rounded-3xl p-8 shadow-2xl">
            <h3 class="text-xl font-black text-white italic mb-8 flex items-center gap-3 underline decoration-brand-yellow decoration-4 underline-offset-8">
                TREN PENGELUARAN 📈
            </h3>
            <div class="h-64">
                <canvas id="spendTrendChart"></canvas>
            </div>
        </div>

        <!-- Top Games Spend -->
        <div class="bg-dark-800 border border-gray-700/50 rounded-3xl p-8 shadow-2xl">
            <h3 class="text-xl font-black text-white italic mb-8 flex items-center gap-3 underline decoration-brand-yellow decoration-4 underline-offset-8">
                TOP GAME TOPUP 🎮
            </h3>
            <div class="space-y-6">
                @forelse($gameSpend as $item)
                    <div class="group">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-300 font-bold group-hover:text-brand-yellow transition-colors italic">{{ $item->game->name }}</span>
                            <span class="text-white font-black italic">Rp {{ number_format($item->total, 0, ',', '.') }}</span>
                        </div>
                        <div class="w-full bg-dark-900 rounded-full h-3 overflow-hidden border border-gray-700/50">
                            <div class="bg-gradient-to-r from-brand-yellow to-yellow-600 h-full rounded-full transition-all duration-1000" 
                                 style="width: {{ $stats['total_spent'] > 0 ? ($item->total / $stats['total_spent']) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 text-gray-500 italic">Belum ada data pengeluaran.</div>
                @endforelse
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('livewire:init', () => {
            const ctx = document.getElementById('spendTrendChart');
            if (ctx) {
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: @js($monthlySpend->pluck('month')),
                        datasets: [{
                            label: 'Pengeluaran (Rp)',
                            data: @js($monthlySpend->pluck('total')),
                            borderColor: '#FACC15',
                            backgroundColor: 'rgba(250, 204, 21, 0.1)',
                            borderWidth: 4,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 6,
                            pointBackgroundColor: '#0F172A',
                            pointBorderWidth: 2,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#1E293B',
                                titleFont: { family: 'Inter', weight: 'bold' },
                                bodyFont: { family: 'Inter' },
                                padding: 12,
                                cornerRadius: 10,
                                callbacks: {
                                    label: function(context) {
                                        return ' Rp ' + context.parsed.y.toLocaleString('id-ID');
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                grid: { color: 'rgba(255, 255, 255, 0.05)' },
                                ticks: { 
                                    color: '#94A3B8',
                                    callback: function(value) {
                                        if (value >= 1000000) return (value / 1000000) + 'M';
                                        if (value >= 1000) return (value / 1000) + 'K';
                                        return value;
                                    }
                                }
                            },
                            x: {
                                grid: { display: false },
                                ticks: { color: '#94A3B8' }
                            }
                        }
                    }
                });
            }
        });
    </script>
    @endpush
</div>

<div wire:poll.5s="loadStats" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-5">
    <!-- Total Orders -->
    <div class="relative overflow-hidden p-6 bg-dark-800 border border-gray-700/50 rounded-2xl group hover:border-blue-500/50 transition-all duration-300 hover:shadow-lg hover:shadow-blue-500/10">
        <div class="relative z-10">
            <p class="text-sm font-medium text-blue-400 uppercase tracking-wider">Total Orders</p>
            <p class="mt-2 text-3xl font-black text-white group-hover:scale-105 transition-transform origin-left">{{ number_format($totalOrders) }}</p>
            <div class="mt-2 text-xs text-gray-400">Lifetime transactions</div>
        </div>
    </div>

    <!-- Total Revenue -->
    <div class="relative overflow-hidden p-6 bg-dark-800 border border-gray-700/50 rounded-2xl group hover:border-green-500/50 transition-all duration-300 hover:shadow-lg hover:shadow-green-500/10">
        <div class="relative z-10">
            <p class="text-sm font-medium text-green-400 uppercase tracking-wider">Total Revenue</p>
            <p class="mt-2 text-3xl font-black text-white group-hover:scale-105 transition-transform origin-left">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            <div class="mt-2 text-xs text-gray-400">Lifetime earnings</div>
        </div>
    </div>

    <!-- Today Orders -->
    <div class="relative overflow-hidden p-6 bg-dark-800 border border-gray-700/50 rounded-2xl group hover:border-purple-500/50 transition-all duration-300 hover:shadow-lg hover:shadow-purple-500/10">
        <div class="relative z-10">
            <p class="text-sm font-medium text-purple-400 uppercase tracking-wider">Today Orders</p>
            <p class="mt-2 text-3xl font-black text-white group-hover:scale-105 transition-transform origin-left">{{ number_format($todayOrders) }}</p>
            <div class="mt-2 text-xs text-gray-400">Orders today</div>
        </div>
    </div>

    <!-- Today Revenue -->
    <div class="relative overflow-hidden p-6 bg-dark-800 border border-gray-700/50 rounded-2xl group hover:border-brand-yellow/50 transition-all duration-300 hover:shadow-lg hover:shadow-brand-yellow/10">
        <div class="relative z-10">
            <p class="text-sm font-medium text-brand-yellow uppercase tracking-wider">Today Revenue</p>
            <p class="mt-2 text-3xl font-black text-white group-hover:scale-105 transition-transform origin-left">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</p>
            <div class="mt-2 text-xs text-gray-400">Earnings today</div>
        </div>
    </div>

    <!-- Pending Orders -->
    <div class="relative overflow-hidden p-6 bg-dark-800 border border-gray-700/50 rounded-2xl group hover:border-red-500/50 transition-all duration-300 hover:shadow-lg hover:shadow-red-500/10">
        <div class="relative z-10">
            <p class="text-sm font-medium text-red-400 uppercase tracking-wider">Pending Orders</p>
            <p class="mt-2 text-3xl font-black text-white group-hover:scale-105 transition-transform origin-left">{{ number_format($pendingOrders) }}</p>
            <div class="mt-2 text-xs text-gray-400">Need attention</div>
        </div>
    </div>

    <!-- Sales Trend Chart -->
    <div class="lg:col-span-5 bg-dark-800 border border-gray-700/50 rounded-2xl p-6 mt-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-white italic uppercase tracking-wider">Tren Penjualan (7 Hari Terakhir)</h3>
            <div class="text-xs text-gray-500 font-medium">Automatic updates every 5s</div>
        </div>
        <div class="h-[300px] relative">
            <canvas id="salesChart" wire:ignore></canvas>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            const ctx = document.getElementById('salesChart');
            let chart;

            const initChart = (data) => {
                if(chart) chart.destroy();
                
                chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.map(d => d.label),
                        datasets: [{
                            label: 'Pendapatan (Rp)',
                            data: data.map(d => d.revenue),
                            borderColor: '#FACB15',
                            backgroundColor: 'rgba(250, 203, 21, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#FACB15',
                            pointBorderColor: '#000',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#111827',
                                titleFont: { size: 14, weight: 'bold' },
                                bodyFont: { size: 12 },
                                padding: 12,
                                displayColors: false,
                                callbacks: {
                                    label: function(context) {
                                        return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: { color: 'rgba(255, 255, 255, 0.05)' },
                                ticks: { 
                                    color: '#9ca3af',
                                    callback: function(value) {
                                        if (value >= 1000000) return (value/1000000) + 'M';
                                        if (value >= 1000) return (value/1000) + 'K';
                                        return value;
                                    }
                                }
                            },
                            x: {
                                grid: { display: false },
                                ticks: { color: '#9ca3af' }
                            }
                        }
                    }
                });
            };

            // Initialize
            initChart(@json($salesData));

            // Sync with Livewire updates
            Livewire.on('statsUpdated', (data) => {
                initChart(data[0].salesData);
            });
        });
    </script>
    @endpush
</div>

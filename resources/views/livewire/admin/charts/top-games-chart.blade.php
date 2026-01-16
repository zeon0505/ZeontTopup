<div class="bg-dark-800 p-6 rounded-2xl border border-gray-700/50 shadow-xl">
    <h3 class="text-lg font-bold text-white mb-6 flex items-center gap-2">
        <span class="bg-brand-yellow/10 p-1.5 rounded-lg">
            <svg class="w-5 h-5 text-brand-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
        </span>
        Top 5 Games by Revenue
    </h3>
    
    <div x-data="{
        init() {
            let options = {
                series: [{
                    name: 'Revenue',
                    data: @js($chartData['series'] ?? [])
                }],
                chart: {
                    type: 'bar',
                    height: 300,
                    toolbar: { show: false },
                    fontFamily: 'Inter, sans-serif'
                },
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        horizontal: true,
                        barHeight: '60%',
                    }
                },
                dataLabels: {
                    enabled: false
                },
                colors: ['#FACC15'],
                xaxis: {
                    categories: @js($chartData['categories'] ?? []),
                    labels: {
                        style: { colors: '#94a3b8' },
                        formatter: function (val) {
                            return 'Rp ' + val.toLocaleString('id-ID');
                        }
                    },
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                yaxis: {
                    labels: { style: { colors: '#f8fafc', fontWeight: 600 } }
                },
                grid: {
                    borderColor: '#334155',
                    strokeDashArray: 4,
                    xaxis: { lines: { show: true } }
                },
                theme: { mode: 'dark' },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return 'Rp ' + val.toLocaleString('id-ID');
                        }
                    }
                }
            };
            
            let chart = new ApexCharts(this.$refs.chart, options);
            chart.render();
        }
    }">
        <div x-ref="chart"></div>
    </div>
</div>

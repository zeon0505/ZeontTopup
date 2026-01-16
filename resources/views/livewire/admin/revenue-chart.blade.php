<div class="bg-dark-800 border border-gray-700/50 rounded-2xl p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-white font-bold text-lg">Revenue Overview</h3>
            <p class="text-sm text-gray-400">Sales performance over the last 7 days</p>
        </div>
    </div>

    <!-- Chart Container -->
    <div id="revenueChart" class="w-full h-[350px]"></div>

    <!-- ApexCharts Script -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            const options = {
                series: [{
                    name: 'Revenue',
                    data: @json($chartData['series'])
                }],
                chart: {
                    type: 'area',
                    height: 350,
                    toolbar: { show: false },
                    background: 'transparent'
                },
                colors: ['#FCD34D'], // Brand Yellow
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.7,
                        opacityTo: 0.1, // Fade to transparent
                        stops: [0, 90, 100]
                    }
                },
                dataLabels: { enabled: false },
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                xaxis: {
                    categories: @json($chartData['categories']),
                    labels: { style: { colors: '#9CA3AF' } },
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                yaxis: {
                    labels: {
                        style: { colors: '#9CA3AF' },
                        formatter: (value) => {
                            if (value >= 1000000) return 'Rp ' + (value / 1000000).toFixed(1) + 'M';
                            if (value >= 1000) return 'Rp ' + (value / 1000).toFixed(0) + 'k';
                            return 'Rp ' + value;
                        }
                    }
                },
                grid: {
                    borderColor: '#374151',
                    strokeDashArray: 4,
                },
                theme: { mode: 'dark' },
                tooltip: {
                    theme: 'dark',
                    y: {
                        formatter: function (val) {
                            return "Rp " + new Intl.NumberFormat('id-ID').format(val);
                        }
                    }
                }
            };

            const chart = new ApexCharts(document.querySelector("#revenueChart"), options);
            chart.render();
        });
    </script>
</div>

<x-admin-layout title="Admin Dashboard">
    <!-- Dashboard Stats -->
    <div class="mb-8">
        <livewire:admin.dashboard-stats />
    </div>

    <!-- Revenue Chart -->
    <div class="mb-8">
        <livewire:admin.revenue-chart />
    </div>

    <!-- Analytics Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Top Games Chart -->
        <div>
            <livewire:admin.charts.top-games-chart />
        </div>
        
        <!-- Recent Users -->
        <div>
             <livewire:admin.components.recent-users />
        </div>
    </div>

    <div class="mb-6">
        <h2 class="text-xl font-bold text-white mb-4">Akses Cepat</h2>
        <!-- Quick Links -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <a href="{{ route('admin.games.index') }}" class="block p-6 bg-dark-800 rounded-xl border border-gray-700 hover:border-brand-yellow transition-all group">
                <div class="flex items-center gap-4">
                    <div class="p-4 bg-brand-yellow/10 rounded-lg group-hover:bg-brand-yellow group-hover:text-black transition-colors text-brand-yellow">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-white group-hover:text-brand-yellow transition-colors">Kelola Games</h3>
                        <p class="text-sm text-gray-400">Tambah & edit game</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.products.index') }}" class="block p-6 bg-dark-800 rounded-xl border border-gray-700 hover:border-brand-yellow transition-all group">
                <div class="flex items-center gap-4">
                    <div class="p-4 bg-brand-yellow/10 rounded-lg group-hover:bg-brand-yellow group-hover:text-black transition-colors text-brand-yellow">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-white group-hover:text-brand-yellow transition-colors">Kelola Produk</h3>
                        <p class="text-sm text-gray-400">Setting harga & nominal</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.orders') }}" class="block p-6 bg-dark-800 rounded-xl border border-gray-700 hover:border-brand-yellow transition-all group">
                <div class="flex items-center gap-4">
                    <div class="p-4 bg-brand-yellow/10 rounded-lg group-hover:bg-brand-yellow group-hover:text-black transition-colors text-brand-yellow">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-white group-hover:text-brand-yellow transition-colors">Semua Pesanan</h3>
                        <p class="text-sm text-gray-400">Cek status transaksi</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.flash-sales.index') }}" class="block p-6 bg-dark-800 rounded-xl border border-gray-700 hover:border-brand-yellow transition-all group">
                <div class="flex items-center gap-4">
                    <div class="p-4 bg-brand-yellow/10 rounded-lg group-hover:bg-brand-yellow group-hover:text-black transition-colors text-brand-yellow">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-white group-hover:text-brand-yellow transition-colors">Flash Sales</h3>
                        <p class="text-sm text-gray-400">Kelola Diskon & Promo</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</x-admin-layout>

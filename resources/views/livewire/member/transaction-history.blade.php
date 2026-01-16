<div class="bg-dark-800 rounded-2xl border border-gray-700/50 overflow-hidden shadow-xl">
    <!-- Header with Filters -->
    <div class="p-6 border-b border-gray-700/50 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-white">Riwayat Transaksi</h2>
            <p class="text-sm text-gray-400">Pantau semua status top up game kamu disini.</p>
        </div>
        
        <!-- Status Tabs -->
        <div class="flex bg-dark-900 rounded-xl p-1 gap-1 overflow-x-auto">
            @foreach(['all' => 'Semua', 'pending' => 'Menunggu', 'processing' => 'Proses', 'completed' => 'Sukses', 'failed' => 'Gagal'] as $key => $label)
                <button 
                    wire:click="setStatusFilter('{{ $key }}')"
                    class="px-4 py-2 rounded-lg text-sm font-medium whitespace-nowrap transition-all
                    {{ $statusFilter === $key 
                        ? 'bg-brand-yellow text-black shadow-lg font-bold' 
                        : 'text-gray-400 hover:text-white hover:bg-dark-700' 
                    }}"
                >
                    {{ $label }}
                </button>
            @endforeach
        </div>
    </div>

    <!-- Table Content -->
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-dark-900/50 text-gray-400 text-sm uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-4 font-medium">No. Order</th>
                    <th class="px-6 py-4 font-medium">Game & Item</th>
                    <th class="px-6 py-4 font-medium">Total Harga</th>
                    <th class="px-6 py-4 font-medium">Tanggal</th>
                    <th class="px-6 py-4 font-medium">Status</th>
                    <th class="px-6 py-4 font-medium text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700/50">
                @forelse($orders as $order)
                    <tr class="hover:bg-dark-700/30 transition-colors">
                        <td class="px-6 py-4">
                            <span class="text-white font-mono font-medium">{{ $order->order_number }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-dark-900 border border-gray-700 flex-shrink-0 overflow-hidden">
                                     @if($order->game && $order->game->image)
                                        <img src="{{ Storage::url($order->game->image) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-xs font-bold text-gray-500">
                                            {{ substr($order->game->name ?? 'G', 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <div class="text-white font-bold text-sm">{{ $order->game->name ?? 'Unknown Game' }}</div>
                                    <div class="text-xs text-gray-400">
                                        {{ $order->items->first()->name ?? 'Item' }} 
                                        ({{ $order->game_account_id }})
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-brand-yellow font-bold">
                                Rp {{ number_format($order->total, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-400">
                            {{ $order->created_at->format('d M Y H:i') }}
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $statusClasses = [
                                    'pending' => 'bg-yellow-500/10 text-yellow-500 border-yellow-500/20',
                                    'processing' => 'bg-blue-500/10 text-blue-500 border-blue-500/20',
                                    'completed' => 'bg-green-500/10 text-green-500 border-green-500/20',
                                    'failed' => 'bg-red-500/10 text-red-500 border-red-500/20',
                                    'expired' => 'bg-gray-500/10 text-gray-500 border-gray-500/20',
                                ];
                                $class = $statusClasses[$order->status] ?? $statusClasses['pending'];
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $class }}">
                                {{ strtoupper($order->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                             @if($order->status === 'pending')
                                <a href="{{ route('order.status', $order->order_number) }}" class="text-brand-yellow hover:text-white text-sm font-bold underline decoration-brand-yellow/50 hover:decoration-white transition-all">
                                    Bayar
                                </a>
                            @else
                                <a href="{{ route('order.status', $order->order_number) }}" class="text-gray-400 hover:text-white text-sm font-medium transition-colors">
                                    Detail
                                </a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-500">
                                <svg class="w-12 h-12 mb-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                </svg>
                                <p>Belum ada riwayat transaksi.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="p-4 border-t border-gray-700/50 bg-dark-900/30">
        {{ $orders->links() }}
    </div>
</div>

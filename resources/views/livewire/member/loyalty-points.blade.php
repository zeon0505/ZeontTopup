<div class="space-y-6">
    <!-- Points Card -->
    <div class="bg-dark-800 border border-gray-700/50 rounded-3xl p-8 relative overflow-hidden group">
        <div class="absolute -right-12 -top-12 w-48 h-48 bg-indigo-600/10 rounded-full blur-3xl group-hover:bg-indigo-600/20 transition-colors"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-6">
                <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-indigo-500 to-indigo-700 flex items-center justify-center text-white shadow-[0_0_30px_rgba(79,70,229,0.4)]">
                    <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                </div>
                <div>
                    <h2 class="text-gray-400 text-sm font-bold uppercase tracking-widest mb-1">Loyalty Points</h2>
                    <div class="flex items-baseline gap-2">
                        <span class="text-5xl font-black text-white italic">{{ number_format($user->points) }}</span>
                        <span class="text-indigo-400 font-bold uppercase text-sm">Poin</span>
                    </div>
                </div>
            </div>
            
            <div class="bg-dark-900/50 backdrop-blur-sm border border-gray-700/50 rounded-2xl p-4 md:w-64">
                <p class="text-xs text-gray-400 uppercase font-black mb-2 tracking-tighter">Info Penukaran</p>
                <div class="flex items-center gap-2 text-white">
                    <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                    <span class="text-sm font-bold">1 Poin = Rp 1</span>
                </div>
                <p class="text-[10px] text-gray-500 mt-2">Dapatkan 1 poin setiap belanja kelipatan Rp 1.000</p>
            </div>
        </div>
    </div>

    <!-- History Table -->
    <div class="bg-dark-800 border border-gray-700/50 rounded-3xl overflow-hidden shadow-2xl">
        <div class="p-6 border-b border-gray-700/50 flex justify-between items-center bg-dark-900/30">
            <h3 class="text-xl font-black text-white italic flex items-center gap-3">
                <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                RIWAYAT POIN
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-dark-900/50 text-gray-400 text-xs uppercase font-black">
                    <tr>
                        <th class="px-6 py-4">Keterangan</th>
                        <th class="px-6 py-4">Order</th>
                        <th class="px-6 py-4">Waktu</th>
                        <th class="px-6 py-4 text-right">Poin</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700/50">
                    @forelse($pointsHistory as $history)
                        <tr class="hover:bg-dark-700/30 transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-white italic uppercase">{{ $history->description }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @if($history->order)
                                    <span class="text-xs bg-dark-900 px-2 py-1 rounded text-gray-400 font-mono">#{{ $history->order->order_number }}</span>
                                @else
                                    <span class="text-gray-600 italic">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-xs text-gray-500">{{ $history->created_at->format('d M Y, H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="text-lg font-black italic {{ $history->points > 0 ? 'text-green-500' : 'text-red-500' }}">
                                    {{ $history->points > 0 ? '+' : '' }}{{ number_format($history->points) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500 italic">
                                Belum ada riwayat transaksi poin.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-gray-700/50 bg-dark-900/30">
            {{ $pointsHistory->links() }}
        </div>
    </div>
</div>

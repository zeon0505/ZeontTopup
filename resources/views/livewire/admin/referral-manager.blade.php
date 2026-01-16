<div>
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-white mb-2">Manajemen Referral</h1>
        <p class="text-gray-400">Pantau program referral dan pembagian komisi user.</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-dark-800 p-6 rounded-xl border border-gray-700">
            <div class="text-gray-400 text-xs font-bold uppercase mb-2">Total Referrals</div>
            <div class="text-2xl font-black text-white">{{ $stats['total_referrals'] }}</div>
        </div>
        <div class="bg-dark-800 p-6 rounded-xl border border-gray-700 border-l-4 border-l-green-500">
            <div class="text-gray-400 text-xs font-bold uppercase mb-2">Komisi Dibayarkan</div>
            <div class="text-2xl font-black text-white">Rp {{ number_format($stats['total_commission'], 0, ',', '.') }}</div>
        </div>
        <div class="bg-dark-800 p-6 rounded-xl border border-gray-700 border-l-4 border-l-brand-yellow">
            <div class="text-gray-400 text-xs font-bold uppercase mb-2">Komisi Tertunda</div>
            <div class="text-2xl font-black text-white">Rp {{ number_format($stats['pending_commission'], 0, ',', '.') }}</div>
        </div>
        <div class="bg-dark-800 p-6 rounded-xl border border-gray-700">
            <div class="text-gray-400 text-xs font-bold uppercase mb-2">Top Referrer</div>
            <div class="text-white font-bold truncate">
                {{ $stats['top_referrer'] ? $stats['top_referrer']->name : '-' }}
                <span class="text-xs text-brand-yellow block">({{ $stats['top_referrer'] ? $stats['top_referrer']->referrals_count : 0 }} Undangan)</span>
            </div>
        </div>
    </div>

    <!-- Filters & Table -->
    <div class="bg-dark-800 rounded-xl border border-gray-700 overflow-hidden">
        <div class="p-6 border-b border-gray-700 flex flex-col md:flex-row gap-4 justify-between items-center">
            <div class="relative w-full md:w-96">
                <input wire:model.live.debounce.300ms="search" type="text" 
                    placeholder="Cari nama/email user..." 
                    class="w-full bg-dark-900 border border-gray-700 rounded-lg pl-10 pr-4 py-2 text-white focus:outline-none focus:border-brand-yellow">
                <svg class="w-5 h-5 text-gray-500 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <select wire:model.live="filterStatus" class="bg-dark-900 border border-gray-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-brand-yellow">
                <option value="">Semua Status</option>
                <option value="completed">Completed</option>
                <option value="pending">Pending</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-dark-900/50">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Referrer (Pengajak)</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Referred (Teman)</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Detail Order</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Komisi</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($referrals as $referral)
                        <tr class="hover:bg-white/5 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center text-white font-bold text-xs">
                                        {{ substr($referral->referrer->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-white font-bold text-sm">{{ $referral->referrer->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $referral->referrer->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-brand-yellow flex items-center justify-center text-black font-bold text-xs">
                                        {{ substr($referral->referred->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-white font-bold text-sm">{{ $referral->referred->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $referral->referred->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($referral->order)
                                    <div class="text-white text-xs font-bold">{{ $referral->order->game->name }}</div>
                                    <div class="text-[10px] text-gray-500">{{ $referral->order->order_number }}</div>
                                @else
                                    <span class="text-gray-500">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-green-500 font-bold text-sm">Rp {{ number_format($referral->commission_amount, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @if($referral->status === 'completed')
                                    <span class="px-2 py-1 bg-green-500/10 text-green-500 text-[10px] font-black uppercase rounded border border-green-500/20">Berhasil</span>
                                @elseif($referral->status === 'pending')
                                    <span class="px-2 py-1 bg-brand-yellow/10 text-brand-yellow text-[10px] font-black uppercase rounded border border-brand-yellow/20">Tertunda</span>
                                @else
                                    <span class="px-2 py-1 bg-red-500/10 text-red-500 text-[10px] font-black uppercase rounded border border-red-500/20">Batal</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-400">
                                {{ $referral->created_at->format('d/m/Y H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">Belum ada data referral.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($referrals->hasPages())
            <div class="p-6 border-t border-gray-700">
                {{ $referrals->links() }}
            </div>
        @endif
    </div>
</div>

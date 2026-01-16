<div class="py-12 bg-dark-900 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-indigo-600/20 to-transparent border border-indigo-500/20 rounded-2xl p-6 md:p-8">
            <h1 class="text-3xl font-black text-white italic tracking-tight">REFERRAL PROGRAM 🤝</h1>
            <p class="text-gray-400 mt-2">Undang temanmu dan dapatkan komisi <span class="text-brand-yellow font-bold">2%</span> dari setiap pembelian mereka!</p>
        </div>

        <!-- Referral Link Card -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <div class="bg-dark-800 rounded-2xl border border-gray-700 p-6 md:p-8 h-full flex flex-col justify-center">
                    <h2 class="text-xl font-bold text-white mb-6">Link Referral Kamu</h2>
                    
                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1 bg-dark-900 border border-gray-700 rounded-xl px-4 py-3 flex items-center justify-between group hover:border-indigo-500 transition-colors">
                            <span class="text-gray-300 font-mono text-sm truncate">{{ $referralLink }}</span>
                            <button x-data="{ copied: false }" 
                                    @click="navigator.clipboard.writeText('{{ $referralLink }}'); copied = true; setTimeout(() => copied = false, 2000)"
                                    class="ml-4 text-brand-yellow hover:text-white transition-colors flex items-center gap-2">
                                <span x-show="!copied" class="text-xs font-bold uppercase tracking-wider">Copy</span>
                                <span x-show="copied" class="text-xs font-bold uppercase tracking-wider text-green-500">Copied!</span>
                                <svg x-show="!copied" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
                                <svg x-show="copied" class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </button>
                        </div>
                        <div class="bg-indigo-600/10 border border-indigo-500/20 rounded-xl px-4 py-3 flex items-center justify-center gap-3">
                            <span class="text-gray-400 text-xs font-bold uppercase">Kode:</span>
                            <span class="text-white font-black tracking-widest">{{ $referralCode }}</span>
                        </div>
                    </div>

                    <div class="mt-8 flex flex-col md:flex-row gap-8">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-indigo-600/20 flex items-center justify-center text-indigo-400 font-bold">1</div>
                            <div>
                                <p class="text-white font-bold text-sm">Bagikan Link</p>
                                <p class="text-gray-500 text-xs">Share link ke teman-temanmu.</p>
                            </div>
                        </div>
                        <div class="hidden md:block self-center h-px flex-1 bg-gray-800"></div>
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-indigo-600/20 flex items-center justify-center text-indigo-400 font-bold">2</div>
                            <div>
                                <p class="text-white font-bold text-sm">Teman Bergabung</p>
                                <p class="text-gray-500 text-xs">Teman daftar lewat linkmu.</p>
                            </div>
                        </div>
                        <div class="hidden md:block self-center h-px flex-1 bg-gray-800"></div>
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-indigo-600/20 flex items-center justify-center text-indigo-400 font-bold">3</div>
                            <div>
                                <p class="text-white font-bold text-sm">Dapatkan Saldo</p>
                                <p class="text-gray-500 text-xs">Terima komisi tiap mereka beli.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Column -->
            <div class="space-y-6 h-full">
                <!-- Total Earnings -->
                <div class="bg-indigo-600 rounded-2xl p-6 shadow-lg shadow-indigo-600/20">
                    <div class="text-indigo-100 text-sm font-bold uppercase tracking-wider mb-2">Total Komisi</div>
                    <div class="text-white text-3xl font-black">Rp {{ number_format($stats['total_earnings'], 0, ',', '.') }}</div>
                    <div class="mt-4 pt-4 border-t border-white/10 flex justify-between items-center">
                        <span class="text-indigo-100 text-xs">Pendapatan Tertunda:</span>
                        <span class="text-white font-bold text-sm">Rp {{ number_format($stats['pending_earnings'], 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Total Referrals -->
                <div class="bg-dark-800 rounded-2xl border border-gray-700 p-6">
                    <div class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-2">Total Teman</div>
                    <div class="flex items-end justify-between">
                        <div class="text-white text-3xl font-black">{{ $stats['total_referrals'] }}</div>
                        <div class="p-3 bg-brand-yellow/10 rounded-lg text-brand-yellow">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- History Table -->
        <div class="bg-dark-800 rounded-2xl border border-gray-700 overflow-hidden">
            <div class="p-6 border-b border-gray-700 flex justify-between items-center">
                <h2 class="text-xl font-bold text-white">Riwayat Komisi</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-dark-900/50">
                        <tr>
                            <th class="px-6 py-4 text-gray-400 text-xs font-bold uppercase">Tanggal</th>
                            <th class="px-6 py-4 text-gray-400 text-xs font-bold uppercase">Teman</th>
                            <th class="px-6 py-4 text-gray-400 text-xs font-bold uppercase">Game / Order</th>
                            <th class="px-6 py-4 text-gray-400 text-xs font-bold uppercase">Komisi</th>
                            <th class="px-6 py-4 text-gray-400 text-xs font-bold uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @forelse($history as $item)
                            <tr class="hover:bg-white/5 transition-colors">
                                <td class="px-6 py-4 text-sm text-gray-300">
                                    {{ $item->created_at->format('d M Y, H:i') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-brand-yellow/10 flex items-center justify-center text-brand-yellow font-bold text-xs">
                                            {{ substr($item->referred->name, 0, 1) }}
                                        </div>
                                        <span class="text-white font-medium text-sm">{{ $item->referred->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($item->order)
                                        <div class="text-white text-sm font-bold">{{ $item->order->game->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $item->order->order_number }}</div>
                                    @else
                                        <span class="text-gray-500">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-green-500 font-bold">+Rp {{ number_format($item->commission_amount, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($item->status === 'completed')
                                        <span class="px-2 py-1 bg-green-500/10 text-green-500 text-[10px] font-black uppercase rounded border border-green-500/20">Berhasil</span>
                                    @elseif($item->status === 'pending')
                                        <span class="px-2 py-1 bg-brand-yellow/10 text-brand-yellow text-[10px] font-black uppercase rounded border border-brand-yellow/20">Tertunda</span>
                                    @else
                                        <span class="px-2 py-1 bg-red-500/10 text-red-500 text-[10px] font-black uppercase rounded border border-red-500/20">Batal</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <svg class="w-12 h-12 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                        <p class="text-gray-400">Belum ada riwayat komisi.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($history->hasPages())
                <div class="px-6 py-4 border-t border-gray-700">
                    {{ $history->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

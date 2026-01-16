<div class="relative w-full">
    <div class="relative">
        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>
        <input
            wire:model.live.debounce.300ms="search"
            type="text"
            class="block w-full py-2.5 pl-10 pr-3 text-sm text-white placeholder-gray-400 bg-slate-800 border border-gray-700/50 rounded-lg focus:ring-brand-yellow focus:border-brand-yellow focus:bg-slate-800/80 transition-all"
            placeholder="Cari Game atau Voucher..."
        >
    </div>

    @if(count($results) > 0)
        <div class="absolute top-full left-0 right-0 mt-2 bg-dark-800 border border-gray-700 rounded-xl shadow-2xl z-50 overflow-hidden">
            <ul class="divide-y divide-gray-700/50">
                @foreach($results as $game)
                    <li>
                        <button
                            wire:click="selectGame('{{ $game->slug }}')"
                            class="flex items-center w-full px-4 py-3 text-left transition-colors hover:bg-slate-700/50 group"
                        >
                            <img src="{{ Storage::url($game->image) }}" alt="{{ $game->name }}" class="w-10 h-10 rounded-lg object-cover mr-3 bg-slate-900 shadow-sm group-hover:scale-105 transition-transform">
                            <div>
                                <div class="text-sm font-bold text-white group-hover:text-brand-yellow transition-colors">{{ $game->name }}</div>
                                <div class="text-xs text-gray-400 truncate max-w-[200px]">{{ $game->publisher ?? 'Game Publisher' }}</div>
                            </div>
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>
    @elseif(strlen($search) >= 2)
        <div class="absolute top-full left-0 right-0 mt-2 bg-dark-800 border border-gray-700 rounded-xl shadow-2xl z-50 p-4 text-center">
            <p class="text-sm text-gray-400">
                Game tidak ditemukan.
            </p>
        </div>
    @endif
</div>

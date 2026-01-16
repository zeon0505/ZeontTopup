<div class="relative group/fav">
    <button wire:click.prevent="toggleFavorite" 
            class="w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300 {{ $isFavorite ? 'bg-red-500 text-white shadow-[0_0_20px_rgba(239,68,68,0.5)]' : 'bg-black/20 text-white/70 hover:bg-black/40 border border-white/5 hover:border-white/20' }}">
        <svg xmlns="http://www.w3.org/2000/svg" 
             class="w-5 h-5 transition-transform duration-300 group-hover/fav:scale-125 {{ $isFavorite ? 'fill-current' : 'fill-none' }}" 
             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
        </svg>
    </button>
</div>

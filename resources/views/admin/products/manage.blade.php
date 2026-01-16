<x-admin-layout title="Manage Products: {{ $game->name }}">
    <div class="mb-6">
        <a href="{{ route('admin.products.index') }}" class="inline-flex items-center text-gray-400 hover:text-white mb-4 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Games
        </a>
        
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-xl overflow-hidden border border-gray-700">
                @if($game->image)
                    <img src="{{ Storage::url($game->image) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gray-800 flex items-center justify-center text-xs font-bold text-gray-500">IMG</div>
                @endif
            </div>
            <div>
                <h1 class="text-3xl font-black text-white">{{ $game->name }}</h1>
                <p class="text-gray-400">Manage top up packages and pricing</p>
            </div>
        </div>
    </div>

    <livewire:admin.game-products :game="$game" />
</x-admin-layout>

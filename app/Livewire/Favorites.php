<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('My Favorites - ZeonGame')]
class Favorites extends Component
{
    protected $listeners = ['favoriteUpdated' => '$refresh'];

    public function toggleFavorite($gameId)
    {
        $user = auth()->user();
        
        if ($user->favorites()->where('game_id', $gameId)->exists()) {
            // Remove from favorites
            $user->favorites()->detach($gameId);
            $this->dispatch('show-notification', message: 'Removed from favorites', type: 'info');
        } else {
            // Add to favorites
            $user->favorites()->attach($gameId);
            $this->dispatch('show-notification', message: 'Added to favorites! ❤️', type: 'success');
        }
    }

    public function removeFavorite($gameId)
    {
        auth()->user()->favorites()->detach($gameId);
        $this->dispatch('show-notification', message: 'Removed from favorites', type: 'info');
    }

    public function render()
    {
        $favorites = auth()->user()->favorites()
            ->with('activeFlashSale')
            ->latest('user_favorites.created_at')
            ->get();

        return view('livewire.favorites', [
            'favorites' => $favorites,
        ]);
    }
}

<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Game;
use Illuminate\Support\Facades\Auth;

class FavoriteButton extends Component
{
    public $gameId;
    public $isFavorite = false;

    public function mount($gameId)
    {
        $this->gameId = $gameId;
        $this->checkFavoriteStatus();
    }

    public function checkFavoriteStatus()
    {
        if (Auth::check()) {
            $this->isFavorite = Auth::user()->favorites()->where('game_id', $this->gameId)->exists();
        }
    }

    public function toggleFavorite()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        if ($this->isFavorite) {
            $user->favorites()->detach($this->gameId);
            $this->isFavorite = false;
        } else {
            $user->favorites()->attach($this->gameId);
            $this->isFavorite = true;
        }

        $this->dispatch('favoriteUpdated');
    }

    public function render()
    {
        return view('livewire.favorite-button');
    }
}

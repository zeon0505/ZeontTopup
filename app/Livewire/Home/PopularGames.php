<?php

namespace App\Livewire\Home;

use App\Models\Game;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class PopularGames extends Component
{
    public $activeCategory = 'Top Up Games';

    public $categories = [
        'Top Up Games',
        'Specialist MLBB',
        'Specialist PUBGM',
        'Voucher',
    ];

    public function setCategory($category)
    {
        $this->activeCategory = $category;
    }

    public function toggleFavorite($gameId)
    {
        if (!auth()->check()) {
            $this->dispatch('show-notification', message: 'Please login to add favorites', type: 'warning');
            return;
        }

        $user = auth()->user();
        
        if ($user->favorites()->where('game_id', $gameId)->exists()) {
            $user->favorites()->detach($gameId);
            $this->dispatch('show-notification', message: 'Removed from favorites', type: 'info');
        } else {
            $user->favorites()->attach($gameId);
            $this->dispatch('show-notification', message: 'Added to favorites! ❤️', type: 'success');
        }
    }

    public function render()
    {
        $games = Game::where('is_active', true)
            ->when($this->activeCategory === 'Top Up Games', function ($query) {
                // Show all games except Vouchers
                return $query->where('category', '!=', 'Voucher');
            })
            ->when($this->activeCategory !== 'Top Up Games', function ($query) {
                // Strict filter for other categories
                return $query->where('category', $this->activeCategory);
            })
            ->orderBy('sort_order', 'asc')
            ->get();

        // Fallback: If no games in this category (initial state), show all or some default?
        // Since we just migrated, all games are 'Top Up Games'.
        // So 'Top Up Games' tab will show everything. 'Voucher' will show nothing until updated in admin.
        
        return view('livewire.home.popular-games', [
            'games' => $games
        ]);
    }
}

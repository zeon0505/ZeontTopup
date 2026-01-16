<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Game;

class GameDetail extends Component
{
    public Game $game;

    public function mount(Game $game)
    {
        $this->game = $game;
    }

    public function back()
    {
        return redirect()->route('admin.games.index');
    }

    public function edit()
    {
        return redirect()->route('admin.games.edit', $this->game);
    }

    public function render()
    {
        // Load related data if needed
        $this->game->load('products');
        
        return view('livewire.admin.game-detail');
    }
}

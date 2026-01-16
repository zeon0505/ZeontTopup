<?php

namespace App\Livewire;

use Livewire\Component;

class GameSearch extends Component
{
    public $search = '';
    public $results = [];

    public function updatedSearch()
    {
        if (strlen($this->search) < 2) {
            $this->results = [];
            return;
        }

        $this->results = \App\Models\Game::where('name', 'like', '%' . $this->search . '%')
            // ->where('is_active', true) // Temporarily disabled for debugging/better UX if admin hasn't activated games
            ->orderBy('sort_order', 'asc')
            ->orderBy('name', 'asc')
            ->take(5)
            ->get();
    }

    public function selectGame($slug)
    {
        return redirect()->to('/order/' . $slug);
    }

    public function render()
    {
        return view('livewire.game-search');
    }
}

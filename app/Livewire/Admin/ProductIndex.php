<?php

namespace App\Livewire\Admin;

use App\Models\Product;
use App\Models\Game;
use Livewire\Component;
use Livewire\WithPagination;

class ProductIndex extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $games = Game::withCount('products')
            ->when($this->search, function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('slug', 'like', '%' . $this->search . '%');
            })
            ->orderBy('name')
            ->paginate(12);

        return view('livewire.admin.product-index', [
            'games' => $games
        ]);
    }
}

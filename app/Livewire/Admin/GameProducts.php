<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;

class GameProducts extends Component
{
    use WithPagination;

    public $game;
    public $search = '';

    public function mount(\App\Models\Game $game)
    {
        $this->game = $game;
    }

    public function toggleActive($productId)
    {
        $product = \App\Models\Product::findOrFail($productId);
        $product->update(['is_active' => !$product->is_active]);
        session()->flash('success', 'Product status updated!');
    }

    public function delete($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $product->delete();
        session()->flash('success', 'Product deleted successfully!');
    }

    public function render()
    {
        $products = $this->game->products()
            ->when($this->search, function($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            })
            ->orderBy('price')
            ->paginate(10);

        return view('livewire.admin.game-products', [
            'products' => $products
        ]);
    }
}

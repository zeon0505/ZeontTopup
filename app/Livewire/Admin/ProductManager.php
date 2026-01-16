<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;

class ProductManager extends Component
{
    use WithPagination;

    public $gameId = null;
    public $showModal = false;
    public $editingProductId = null;
    
    // Form fields
    public $name = '';
    public $description = '';
    public $price = 0;
    public $original_price = 0;
    public $quantity = 0;
    public $is_active = true;
    public $provider_name = '';
    public $provider_product_code = '';

    protected $rules = [
        'gameId' => 'required|exists:games,id',
        'name' => 'required|min:3',
        'price' => 'required|numeric|min:0',
        'original_price' => 'nullable|numeric|min:0',
        'quantity' => 'required|integer|min:0',
        'is_active' => 'boolean',
        'provider_name' => 'nullable|string',
        'provider_product_code' => 'nullable|string',
    ];

    public function openCreateModal()
    {
        $this->reset(['name', 'description', 'price', 'original_price', 'quantity', 'editingProductId', 'provider_name', 'provider_product_code']);
        $this->is_active = true;
        $this->showModal = true;
    }

    public function openEditModal($productId)
    {
        $product = \App\Models\Product::findOrFail($productId);
        $this->editingProductId = $product->id;
        $this->gameId = $product->game_id;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->original_price = $product->original_price;
        $this->quantity = $product->quantity;
        $this->is_active = $product->is_active;
        $this->provider_name = $product->provider_name;
        $this->provider_product_code = $product->provider_product_code;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->editingProductId) {
            $product = \App\Models\Product::find($this->editingProductId);
            $product->update([
                'game_id' => $this->gameId,
                'name' => $this->name,
                'description' => $this->description,
                'price' => $this->price,
                'original_price' => $this->original_price,
                'quantity' => $this->quantity,
                'is_active' => $this->is_active,
                'provider_name' => $this->provider_name,
                'provider_product_code' => $this->provider_product_code,
            ]);
        } else {
            \App\Models\Product::create([
                'game_id' => $this->gameId,
                'name' => $this->name,
                'description' => $this->description,
                'price' => $this->price,
                'original_price' => $this->original_price,
                'quantity' => $this->quantity,
                'is_active' => $this->is_active,
                'provider_name' => $this->provider_name,
                'provider_product_code' => $this->provider_product_code,
            ]);
        }

        $this->showModal = false;
        $this->dispatch('show-notification', 'Product saved successfully!', 'success');
    }

    public function delete($productId)
    {
        \App\Models\Product::findOrFail($productId)->delete();
        $this->dispatch('show-notification', 'Product deleted successfully!', 'success');
    }

    public function render()
    {
        $games = \App\Models\Game::where('is_active', true)->get();
        $products = \App\Models\Product::with('game')
            ->when($this->gameId, fn($q) => $q->where('game_id', $this->gameId))
            ->orderBy('game_id')
            ->orderBy('sort_order')
            ->paginate(20);

        return view('livewire.admin.product-manager', [
            'products' => $products,
            'games' => $games,
        ]);
    }
}

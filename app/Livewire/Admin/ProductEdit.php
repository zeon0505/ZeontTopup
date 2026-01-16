<?php

namespace App\Livewire\Admin;

use App\Models\Product;
use App\Models\Game;
use Livewire\Component;

class ProductEdit extends Component
{
    public Product $product;
    
    public $game_id;
    public $name;
    public $description;
    public $price;
    public $original_price;
    public $quantity;
    public $is_active;
    public $provider_name;
    public $provider_product_code;

    protected $rules = [
        'game_id' => 'required|exists:games,id',
        'name' => 'required|min:3',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'original_price' => 'nullable|numeric|min:0',
        'quantity' => 'required|integer|min:0',
        'is_active' => 'boolean',
        'provider_name' => 'nullable|string',
        'provider_product_code' => 'nullable|string',
    ];

    public function mount(Product $product)
    {
        $this->product = $product;
        $this->game_id = $product->game_id;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->original_price = $product->original_price;
        $this->quantity = $product->quantity;
        $this->is_active = $product->is_active;
        $this->provider_name = $product->provider_name;
        $this->provider_product_code = $product->provider_product_code;
    }

    public function save()
    {
        $this->validate();

        try {
            $this->product->update([
                'game_id' => $this->game_id,
                'name' => $this->name,
                'description' => $this->description,
                'price' => $this->price,
                'original_price' => $this->original_price,
                'quantity' => $this->quantity,
                'is_active' => $this->is_active,
                'provider_name' => $this->provider_name,
                'provider_product_code' => $this->provider_product_code,
            ]);

            session()->flash('success', 'Product updated successfully!');
            $this->dispatch('show-notification', message: 'Product updated successfully!', type: 'success');
            return redirect()->route('admin.products.index');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Error updating product: ' . $e->getMessage());
            $this->dispatch('show-notification', message: 'Error: ' . $e->getMessage(), type: 'error');
        }
    }

    public function cancel()
    {
        return redirect()->route('admin.products.index');
    }

    public function render()
    {
        $games = Game::where('is_active', true)->orderBy('name')->get();
        return view('livewire.admin.product-edit', [
            'games' => $games
        ]);
    }
}

<?php

namespace App\Livewire\Admin;

use App\Models\Product;
use App\Models\Game;
use Livewire\Component;

class ProductCreate extends Component
{
    public $game_id = '';
    public $name = '';
    public $description = '';
    public $price = 0;
    public $original_price = 0;
    public $quantity = 0;
    public $is_active = true;
    public $provider_name = '';
    public $provider_product_code = '';

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

    public function save()
    {
        $this->validate();

        Product::create([
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

        session()->flash('success', 'Product created successfully!');
        return redirect()->route('admin.products.index');
    }

    public function cancel()
    {
        return redirect()->route('admin.products.index');
    }

    public function render()
    {
        $games = Game::where('is_active', true)->orderBy('name')->get();
        return view('livewire.admin.product-create', [
            'games' => $games
        ]);
    }
}

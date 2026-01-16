<?php

namespace App\Livewire;

use Livewire\Component;

class ProductSelector extends Component
{
    public $gameId;
    public $flashSaleProducts = [];
    public $normalProducts = [];
    public $selectedProductId = null;

    public function mount($gameId, $preselectedProductId = null)
    {
        $this->gameId = $gameId;
        $allProducts = \App\Models\Product::where('game_id', $gameId)
            ->with('activeFlashSale')
            ->where('is_active', true)
            ->orderBy('price')
            ->get();
            
        $this->flashSaleProducts = $allProducts->filter(fn($p) => $p->activeFlashSale !== null);
        $this->normalProducts = $allProducts->filter(fn($p) => $p->activeFlashSale === null);
            
        if ($preselectedProductId) {
             $product = $allProducts->firstWhere('id', $preselectedProductId);
             if ($product) {
                 $this->selectProduct($preselectedProductId);
             }
        }
    }

    public function selectProduct($productId)
    {
        $this->selectedProductId = $productId;
        $this->selectedProductId = $productId;
        
        // Re-fetch product with relation to ensure Flash Sale logic works (hydration fix)
        $product = \App\Models\Product::with('activeFlashSale')
            ->where('id', $productId)
            ->first();

        if (!$product) {
            return;
        }
            
        // Explicitly format data to avoid serialization issues and ensure price correctness
        $productData = [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price, // Accessor handles Flash Sale logic
            'original_price' => $product->getRawOriginal('price'),
            'game_id' => $product->game_id,
        ];

        $this->dispatch('product-selected', $productData);
    }

    public function render()
    {
        return view('livewire.product-selector');
    }
}

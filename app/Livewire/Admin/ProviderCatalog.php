<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Services\Fulfillment\ProviderServiceInterface;
use Livewire\WithPagination;

class ProviderCatalog extends Component
{
    use WithPagination;

    public $search = '';
    public $category = 'Games';
    public $brand = '';
    public $isLoading = false;
    
    protected $queryString = ['search', 'category', 'brand'];

    public function getCatalogProperty(ProviderServiceInterface $provider)
    {
        $products = $provider->getProducts();
        
        return collect($products)
            ->when($this->category, fn($c) => $c->where('category', $this->category))
            ->when($this->brand, fn($c) => $c->where('brand', $this->brand))
            ->when($this->search, function($c) {
                return $c->filter(fn($p) => 
                    str_contains(strtolower($p['product_name'] ?? ''), strtolower($this->search)) ||
                    str_contains(strtolower($p['buyer_sku_code'] ?? ''), strtolower($this->search))
                );
            })
            ->sortBy('product_name');
    }

    public function render(ProviderServiceInterface $provider)
    {
        $allProducts = collect($provider->getProducts());
        $categories = $allProducts->pluck('category')->unique()->sort();
        $brands = $allProducts->where('category', $this->category)->pluck('brand')->unique()->sort();

        return view('livewire.admin.provider-catalog', [
            'products' => $this->catalog,
            'categories' => $categories,
            'brands' => $brands,
            'balance' => $provider->getBalance()
        ]);
    }
}

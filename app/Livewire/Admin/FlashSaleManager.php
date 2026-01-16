<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\FlashSale;
use App\Models\Product;
use App\Models\Game;
use Livewire\WithPagination;

class FlashSaleManager extends Component
{
    use WithPagination;

    public $productId;
    public $discountPrice;
    public $startTime;
    public $endTime;
    public $isActive = true;

    public $showCreateModal = false;
    public $selectedGameId;
    public $availableProducts = [];

    protected $rules = [
        'productId' => 'required|exists:products,id',
        'discountPrice' => 'required|numeric|min:1',
        'startTime' => 'required|date',
        'endTime' => 'required|date|after:startTime',
    ];

    public function updatedSelectedGameId($value)
    {
        $this->availableProducts = Product::where('game_id', $value)->where('is_active', true)->get();
        $this->productId = null;
    }

    public function createFlashSale()
    {
        $this->validate();

        FlashSale::create([
            'product_id' => $this->productId,
            'discount_price' => $this->discountPrice,
            'start_time' => $this->startTime,
            'end_time' => $this->endTime,
            'is_active' => $this->isActive,
        ]);

        $this->reset(['showCreateModal', 'productId', 'discountPrice', 'startTime', 'endTime', 'isActive', 'selectedGameId', 'availableProducts']);
        session()->flash('success', 'Flash Sale created successfully!');
    }

    public function deleteFlashSale($id)
    {
        FlashSale::findOrFail($id)->delete();
        session()->flash('success', 'Flash Sale deleted successfully!');
    }

    public function toggleStatus($id)
    {
        $fs = FlashSale::findOrFail($id);
        $fs->update(['is_active' => !$fs->is_active]);
    }

    public function render()
    {
        return view('livewire.admin.flash-sale-manager', [
            'flashSales' => FlashSale::with('product.game')->latest()->paginate(10),
            'games' => Game::where('is_active', true)->get()
        ]);
    }
}

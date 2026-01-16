<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;

class TransactionCheck extends Component
{
    public $search = '';
    public $orders = [];
    public $hasSearched = false;

    public function findTransaction()
    {
        $this->validate([
            'search' => 'required|min:3',
        ]);

        $this->orders = Order::where('invoice', 'like', '%' . $this->search . '%')
            ->orWhere('phone_number', 'like', '%' . $this->search . '%')
            ->latest()
            ->take(10)
            ->get();

        $this->hasSearched = true;
    }

    public function render()
    {
        return view('livewire.transaction-check')->layout('components.layouts.app');
    }
}

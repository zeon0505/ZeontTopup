<?php

namespace App\Livewire;

use Livewire\Component;

class OrderStatus extends Component
{
    public $orderId;
    public $order;

    public function mount($orderId)
    {
        $this->orderId = $orderId;
        $this->checkStatus();
    }

    public function checkStatus()
    {
        $this->order = \App\Models\Order::with(['game', 'items', 'payment'])->find($this->orderId);
    }

    public function render()
    {
        return view('livewire.order-status');
    }
}

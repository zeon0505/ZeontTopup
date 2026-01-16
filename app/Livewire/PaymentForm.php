<?php

namespace App\Livewire;

use Livewire\Component;

class PaymentForm extends Component
{
    public $paymentMethods = [];
    public $selectedMethodCode = null;

    public function mount()
    {
        $this->paymentMethods = \App\Models\PaymentMethod::where('is_active', true)
            ->get()
            ->groupBy('category')
            ->toArray();
        
        // Auto-select first available payment method
        $firstCategory = array_key_first($this->paymentMethods);
        if ($firstCategory && !empty($this->paymentMethods[$firstCategory])) {
            $firstMethod = $this->paymentMethods[$firstCategory][0];
            $this->selectMethod($firstMethod['code'], $firstCategory);
        }
    }

    public function selectMethod($code, $category)
    {
        if (!isset($this->paymentMethods[$category])) {
            return;
        }

        $this->selectedMethodCode = $code;
        $method = collect($this->paymentMethods[$category])->firstWhere('code', $code);
        
        if ($method) {
            $this->dispatch('payment-method-selected', $method);
        }
    }

    public function render()
    {
        return view('livewire.payment-form');
    }
}

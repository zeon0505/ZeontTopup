<?php

namespace App\Livewire\Features;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class Calculator extends Component
{
    public function render()
    {
        return view('livewire.features.calculator');
    }
}

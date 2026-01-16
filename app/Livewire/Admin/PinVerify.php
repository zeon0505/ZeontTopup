<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;

#[Layout('components.admin-layout')]
class PinVerify extends Component
{
    public $pin = '';

    public function verify()
    {
        $this->validate([
            'pin' => 'required|digits:6',
        ]);

        if ($this->pin === auth()->user()->security_pin) {
            Session::put('admin_pin_verified', true);
            return redirect()->route('admin.dashboard');
        }

        $this->addError('pin', 'Security PIN yang Anda masukkan salah.');
        $this->pin = '';
    }

    public function render()
    {
        return view('livewire.admin.pin-verify');
    }
}

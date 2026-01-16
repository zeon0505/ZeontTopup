<?php

namespace App\Livewire\Member;

use Livewire\Component;

use Livewire\Attributes\Layout;
use App\Models\Deposit;
use App\Models\PaymentMethod;
use App\Services\PaymentService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.app')]
class DepositForm extends Component
{
    public $amount = 0;
    public $paymentMethodId;
    public $paymentMethods = [];

    protected $rules = [
        'amount' => 'required|numeric|min:10000',
        'paymentMethodId' => 'required|exists:payment_methods,id',
    ];

    public function mount()
    {
        $this->paymentMethods = PaymentMethod::where('is_active', true)->orderBy('category')->get();
    }

    public function setAmount($value)
    {
        $this->amount = $value;
    }

    public function selectPaymentMethod($id)
    {
        $this->paymentMethodId = $id;
    }

    public function processDeposit(PaymentService $paymentService)
    {
        $this->validate();

        $paymentMethod = PaymentMethod::find($this->paymentMethodId);

        // Create Deposit Record
        $deposit = Deposit::create([
            'deposit_number' => 'DEP-' . strtoupper(Str::random(10)),
            'user_id' => Auth::id(),
            'amount' => $this->amount,
            'status' => 'pending',
        ]);

        try {
            \Illuminate\Support\Facades\Log::info('Initiating deposit', [
                'user_id' => Auth::id(),
                'amount' => $this->amount,
                'method' => $paymentMethod->code
            ]);

            // Generate Snap Token
            $snapToken = $paymentService->createDepositSnapToken($deposit, $paymentMethod->code);
            
            \Illuminate\Support\Facades\Log::info('Deposit snap token generated', ['token' => $snapToken]);

            $deposit->update(['snap_token' => $snapToken]);

            // Dispatch event for Frontend to trigger Snap
            $this->dispatch('deposit-initiated', snap_token: $snapToken, deposit_number: $deposit->deposit_number);
            
             // Also try window event as fallback
            $this->js("window.dispatchEvent(new CustomEvent('deposit-initiated', { detail: { snap_token: '{$snapToken}', deposit_number: '{$deposit->deposit_number}' } }))");

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Deposit Error: ' . $e->getMessage());
            session()->flash('error', 'Failed to create deposit: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.member.deposit-form');
    }
}

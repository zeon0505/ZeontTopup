<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.guest')]
class Register extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function mount()
    {
        // Capture referral code from URL if provided
        if (request()->has('ref')) {
            session(['referred_by_code' => request()->get('ref')]);
        }
    }

    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        // Check for referral
        $referralCode = session('referred_by_code');
        if ($referralCode) {
            $referrer = User::where('referral_code', $referralCode)->first();
            if ($referrer) {
                $validated['referred_by'] = $referrer->id;
            }
        }

        event(new Registered($user = User::create($validated)));

        Auth::login($user);
        
        // Clear referral session
        session()->forget('referred_by_code');

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}

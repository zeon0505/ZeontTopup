<?php

namespace App\Livewire\Member;

use Livewire\Component;

use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

#[Layout('components.layouts.app')]
class ProfileSettings extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $avatar;
    public $existingAvatar;

    // Password Change
    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    // Security PIN
    public $security_pin;

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->existingAvatar = $user->avatar;
        $this->security_pin = $user->security_pin;
    }

    public function updateProfile()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|max:2048', // 2MB Max
        ]);

        $user = Auth::user();
        $data = ['name' => $this->name];

        if ($this->avatar) {
            $data['avatar'] = $this->avatar->store('avatars', 'public');
        }

        $user->update($data);
        
        $this->existingAvatar = $user->avatar;
        $this->reset('avatar');
        
        session()->flash('success', 'Profile updated successfully.');
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required|current_password',
            'new_password' => ['required', 'confirmed', Password::defaults()],
        ]);

        Auth::user()->update([
            'password' => Hash::make($this->new_password),
        ]);

        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
        
        session()->flash('password_success', 'Password changed successfully.');
    }

    public function updateSecurityPin()
    {
        $this->validate([
            'security_pin' => 'required|digits:6',
        ]);

        Auth::user()->update([
            'security_pin' => $this->security_pin,
        ]);

        // Auto-verify in session so they can enter dashboard immediately
        if (Auth::user()->is_admin) {
            session(['admin_pin_verified' => true]);
        }

        session()->flash('pin_success', 'Security PIN updated successfully.');
    }

    public function render()
    {
        return view('livewire.member.profile-settings');
    }
}

<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));
            return;
        }

        $this->reset('email');

        session()->flash('status', __($status));
    }
}; ?>

<div class="min-h-screen flex flex-col justify-center items-center p-6 relative bg-slate-950 overflow-hidden">
    <!-- Background Decor -->
    <div class="absolute top-0 right-1/2 translate-x-1/2 w-[1000px] h-[600px] bg-red-600/10 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-[800px] h-[600px] bg-purple-600/10 rounded-full blur-[100px] pointer-events-none"></div>

    <!-- Card -->
    <div class="w-full max-w-md bg-slate-900/50 backdrop-blur-xl border border-white/10 rounded-3xl p-8 md:p-10 shadow-2xl relative z-10 hover:border-white/20 transition-all">
        <!-- Header -->
        <div class="text-center mb-8">
            <a href="/" class="inline-flex items-center gap-2 mb-6 group">
                <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <span class="text-2xl font-bold text-white tracking-tight">Zeon<span class="text-indigo-400">Game</span></span>
            </a>
            <h1 class="text-2xl font-bold text-white mb-2">Lupa Password? 🔑</h1>
            <p class="text-gray-400">Kami akan mengirimkan link reset ke email Anda.</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-6 p-4 bg-green-500/10 border border-green-500/20 rounded-xl text-green-400" :status="session('status')" />

        <!-- Form -->
        <form wire:submit="sendPasswordResetLink" class="space-y-6">
            <!-- Email -->
            <div class="space-y-2">
                <label for="email" class="text-sm font-medium text-gray-300">Email Address</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-500 group-focus-within:text-brand-yellow transition-colors" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                        </svg>
                    </div>
                    <input wire:model="email" id="email" type="email" required autofocus 
                        class="block w-full pl-11 pr-4 py-3 bg-slate-950/50 border border-slate-700/50 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-brand-yellow/50 focus:border-brand-yellow transition-all hover:bg-slate-950/80"
                        placeholder="nama@email.com">
                </div>
                @error('email') <p class="text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
            </div>

            <button type="submit" 
                class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl text-sm font-bold text-slate-900 bg-brand-yellow hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-yellow transition-all transform hover:scale-[1.02] shadow-[0_4px_14px_0_rgba(250,204,21,0.39)]">
                <span wire:loading.remove>Kirim Link Reset</span>
                <span wire:loading class="flex items-center gap-2">
                    <svg class="animate-spin h-5 w-5 text-slate-900" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Processing...
                </span>
            </button>
        </form>

         <!-- Footer -->
         <div class="mt-8 pt-6 border-t border-white/5 text-center">
            <a href="{{ route('login') }}" wire:navigate class="text-sm font-bold text-brand-yellow hover:text-yellow-300 transition-colors flex items-center justify-center gap-2">
                &larr; Kembali ke Login
            </a>
        </div>
    </div>
</div>

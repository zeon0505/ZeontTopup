<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        if (auth()->user()->is_admin) {
            $this->redirect('/admin/dashboard', navigate: true);
            return;
        }

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="min-h-screen flex flex-col justify-center items-center p-6 relative bg-slate-950 overflow-hidden">
    <!-- Background Decor -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[1000px] h-[600px] bg-brand-yellow/10 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-0 right-0 w-[800px] h-[600px] bg-indigo-600/10 rounded-full blur-[100px] pointer-events-none"></div>

    <!-- Card -->
    <div class="w-full max-w-md bg-slate-900/50 backdrop-blur-xl border border-white/10 rounded-3xl p-8 md:p-10 shadow-2xl relative z-10 hover:border-white/20 transition-all">
        <!-- Header -->
        <div class="text-center mb-10">
            <a href="/" class="inline-flex items-center gap-2 mb-6 group">
                <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <span class="text-2xl font-bold text-white tracking-tight">Zeon<span class="text-indigo-400">Game</span></span>
            </a>
            <h1 class="text-2xl font-bold text-white mb-2">Selamat Datang! 👋</h1>
            <p class="text-gray-400">Masuk untuk melanjutkan petualanganmu</p>
        </div>

        <!-- Form -->
        <form wire:submit="login" class="space-y-6">
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

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
                    <input wire:model="form.email" id="email" type="email" required autofocus 
                        class="block w-full pl-11 pr-4 py-3 bg-slate-950/50 border border-slate-700/50 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-brand-yellow/50 focus:border-brand-yellow transition-all hover:bg-slate-950/80"
                        placeholder="contoh@email.com">
                </div>
                @error('form.email') <p class="text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
            </div>

            <!-- Password -->
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <label for="password" class="text-sm font-medium text-gray-300">Password</label>
                    <a href="{{ route('password.request') }}" wire:navigate class="text-xs font-semibold text-brand-yellow hover:text-yellow-300 transition-colors">
                        Lupa Password?
                    </a>
                </div>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-500 group-focus-within:text-brand-yellow transition-colors" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input wire:model="form.password" id="password" type="password" required 
                        class="block w-full pl-11 pr-4 py-3 bg-slate-950/50 border border-slate-700/50 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-brand-yellow/50 focus:border-brand-yellow transition-all hover:bg-slate-950/80"
                        placeholder="••••••••">
                </div>
                @error('form.password') <p class="text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
            </div>

            <button type="submit" 
                class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl text-sm font-bold text-slate-900 bg-brand-yellow hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-yellow transition-all transform hover:scale-[1.02] shadow-[0_4px_14px_0_rgba(250,204,21,0.39)]">
                <span wire:loading.remove>Masuk Sekarang</span>
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
            <p class="text-sm text-gray-400">
                Belum punya akun?
                <a href="{{ route('register') }}" wire:navigate class="font-bold text-brand-yellow hover:text-yellow-300 transition-colors">
                    Daftar Gratis
                </a>
            </p>
            <div class="mt-4">
                 <a href="/" class="text-xs font-medium text-gray-500 hover:text-white transition-colors">
                    &larr; Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>

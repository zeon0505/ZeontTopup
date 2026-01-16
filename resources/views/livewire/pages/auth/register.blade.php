<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
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
}; ?>

<div class="min-h-screen flex flex-col justify-center items-center p-6 relative bg-slate-950 overflow-hidden">
    <!-- Background Decor -->
    <div class="absolute top-0 right-1/2 translate-x-1/2 w-[1000px] h-[600px] bg-indigo-600/10 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-[800px] h-[600px] bg-brand-yellow/5 rounded-full blur-[100px] pointer-events-none"></div>

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
            <h1 class="text-2xl font-bold text-white mb-2">Buat Akun Baru 🚀</h1>
            <p class="text-gray-400">Bergabunglah dan nikmati fitur eksklusif</p>
        </div>

        <!-- Form -->
        <form wire:submit="register" class="space-y-5">
            <!-- Name -->
            <div class="space-y-2">
                <label for="name" class="text-sm font-medium text-gray-300">Nama Lengkap</label>
                <input wire:model="name" id="name" type="text" required autofocus 
                    class="block w-full px-4 py-3 bg-slate-950/50 border border-slate-700/50 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-brand-yellow/50 focus:border-brand-yellow transition-all hover:bg-slate-950/80"
                    placeholder="Nama Anda">
                @error('name') <p class="text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
            </div>

            <!-- Email -->
            <div class="space-y-2">
                <label for="email" class="text-sm font-medium text-gray-300">Email Address</label>
                <input wire:model="email" id="email" type="email" required 
                    class="block w-full px-4 py-3 bg-slate-950/50 border border-slate-700/50 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-brand-yellow/50 focus:border-brand-yellow transition-all hover:bg-slate-950/80"
                    placeholder="contoh@email.com">
                @error('email') <p class="text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
            </div>

            <!-- Password -->
            <div class="space-y-2">
                <label for="password" class="text-sm font-medium text-gray-300">Password</label>
                <input wire:model="password" id="password" type="password" required 
                    class="block w-full px-4 py-3 bg-slate-950/50 border border-slate-700/50 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-brand-yellow/50 focus:border-brand-yellow transition-all hover:bg-slate-950/80"
                    placeholder="Agak sulit ditebak">
                @error('password') <p class="text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
            </div>

            <!-- Confirm Password -->
            <div class="space-y-2">
                <label for="password_confirmation" class="text-sm font-medium text-gray-300">Konfirmasi Password</label>
                <input wire:model="password_confirmation" id="password_confirmation" type="password" required 
                    class="block w-full px-4 py-3 bg-slate-950/50 border border-slate-700/50 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-brand-yellow/50 focus:border-brand-yellow transition-all hover:bg-slate-950/80"
                    placeholder="Ulangi password">
                @error('password_confirmation') <p class="text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
            </div>

            <button type="submit" 
                class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl text-sm font-bold text-slate-900 bg-brand-yellow hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-yellow transition-all transform hover:scale-[1.02] shadow-[0_4px_14px_0_rgba(250,204,21,0.39)]">
                <span wire:loading.remove>Daftar Sekarang</span>
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
                Sudah punya akun?
                <a href="{{ route('login') }}" wire:navigate class="font-bold text-brand-yellow hover:text-yellow-300 transition-colors">
                    Masuk di sini
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

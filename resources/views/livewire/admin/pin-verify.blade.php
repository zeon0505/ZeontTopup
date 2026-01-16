<div class="min-h-screen flex items-center justify-center bg-dark-900 p-6">
    <div class="max-w-md w-full bg-dark-800 rounded-3xl p-8 border border-gray-700/50 shadow-2xl relative overflow-hidden">
        <!-- Decor -->
        <div class="absolute top-0 right-0 w-32 h-32 bg-brand-yellow/5 rounded-full -mr-16 -mt-16 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-32 h-32 bg-blue-500/5 rounded-full -ml-16 -mb-16 blur-3xl"></div>

        <div class="relative z-10 text-center space-y-6">
            <div class="w-20 h-20 bg-brand-yellow/10 rounded-3xl flex items-center justify-center mx-auto">
                <svg class="w-10 h-10 text-brand-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 0 00-2-2H6a2 0 00-2 2v6a2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            </div>

            <div>
                <h1 class="text-2xl font-black text-white italic uppercase tracking-wider">Verifikasi Keamanan</h1>
                <p class="text-gray-400 mt-2 text-sm leading-relaxed">
                    Harap masukkan 6 digit Security PIN Anda untuk mengakses Dashboard Admin ZeonGame.
                </p>
            </div>

            <form wire:submit.prevent="verify" class="space-y-6">
                <div class="space-y-2">
                    <input 
                        type="password" 
                        maxlength="6" 
                        wire:model="pin" 
                        placeholder="••••••" 
                        class="w-full bg-dark-900 border border-gray-700 rounded-2xl px-4 py-4 text-white focus:ring-2 focus:ring-brand-yellow focus:border-brand-yellow text-center text-4xl font-black tracking-[0.5em] placeholder:tracking-normal placeholder:font-normal"
                        autofocus
                    >
                    @error('pin') 
                        <span class="text-red-500 text-xs font-bold animate-bounce block">{{ $message }}</span> 
                    @enderror
                </div>

                <button 
                    type="submit" 
                    wire:loading.attr="disabled"
                    class="w-full bg-brand-yellow text-black font-black py-4 rounded-2xl hover:bg-yellow-400 transition-all shadow-xl shadow-yellow-500/20 active:scale-95 transform"
                >
                    <span wire:loading.remove wire:target="verify">MASUK DASHBOARD ⚡</span>
                    <span wire:loading wire:target="verify">VERIFIKASI...</span>
                </button>
            </form>

            <div class="pt-4">
                <a href="{{ route('profile') }}" class="text-xs text-gray-500 hover:text-white transition-colors">
                    Lupa PIN? Reset di Pengaturan Profil
                </a>
            </div>
        </div>
    </div>
</div>

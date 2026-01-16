<div class="bg-dark-800 rounded-2xl border border-gray-700/50 overflow-hidden">
    <!-- Header -->
    <div class="p-4 md:p-6 bg-dark-900/50 border-b border-gray-700/50 flex items-center gap-4">
        <div class="w-8 h-8 md:w-10 md:h-10 rounded-full bg-brand-yellow flex items-center justify-center font-black text-black text-lg shadow-[0_0_15px_rgba(255,193,7,0.4)]">
            1
        </div>
        <h2 class="text-lg md:text-xl font-bold text-white">Masukkan Data Akun</h2>
    </div>

    <!-- Content -->
    <div class="p-6 md:p-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label for="accountId" class="text-sm font-medium text-gray-400">User ID</label>
                <div class="relative">
                    <input
                        wire:model="accountId"
                        type="text"
                        id="accountId"
                        class="w-full px-4 py-3 bg-dark-900 border border-gray-700 rounded-xl text-white placeholder-gray-600 focus:border-brand-yellow focus:ring-1 focus:ring-brand-yellow transition-colors outline-none"
                        placeholder="Ketikan User ID"
                    >
                    @if($isValid)
                        <div class="absolute right-3 top-3 text-green-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                    @endif
                </div>
                @if($errorMessage)
                    <p class="text-sm text-red-500 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $errorMessage }}
                    </p>
                @endif
            </div>

            <div class="space-y-2">
                <label for="serverId" class="text-sm font-medium text-gray-400">Server ID (Optional)</label>
                <input
                    type="text"
                    id="serverId"
                    class="w-full px-4 py-3 bg-dark-900 border border-gray-700 rounded-xl text-white placeholder-gray-600 focus:border-brand-yellow focus:ring-1 focus:ring-brand-yellow transition-colors outline-none"
                    placeholder="Ketikan Server ID"
                >
                <p class="text-xs text-gray-500">Biarkan kosong jika game tidak menggunakan Server ID.</p>
            </div>
        </div>

        @if(!$isValid)
            <div class="mt-6 flex justify-end">
                <button
                    wire:click="validateAccount"
                    wire:loading.attr="disabled"
                    class="px-6 py-2 bg-brand-yellow text-black font-bold rounded-xl hover:bg-yellow-400 transition-all shadow-[0_4px_14px_0_rgba(255,193,7,0.39)] disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2"
                >
                    <span wire:loading.remove wire:target="validateAccount">Cek ID Akun</span>
                    <span wire:loading wire:target="validateAccount">
                        <svg class="animate-spin h-5 w-5 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Checking...
                    </span>
                </button>
            </div>
        @else
            <div class="mt-4 p-4 bg-green-500/10 border border-green-500/20 rounded-xl flex items-center gap-4 animate-fade-in">
                <div class="w-10 h-10 rounded-full bg-green-500/20 flex items-center justify-center text-green-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div>
                    <h4 class="text-green-400 text-sm font-bold uppercase tracking-wider">Akun Ditemukan</h4>
                    <p class="text-white text-lg font-bold">{{ $accountName }}</p>
                </div>
            </div>
        @endif
    </div>
</div>

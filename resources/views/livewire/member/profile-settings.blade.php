<div class="min-h-screen py-12 bg-dark-900">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8">
            <h1 class="text-3xl font-black text-white italic tracking-wider uppercase">Pengaturan Akun ⚙️</h1>
            <p class="text-gray-400 mt-2">Kelola informasi profil dan keamanan akun Anda.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Left: Profile Info -->
            <div class="bg-dark-800 rounded-2xl p-6 border border-gray-700/50">
                <h3 class="text-white font-bold text-lg mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-brand-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Informasi Profil
                </h3>

                @if (session('success'))
                    <div class="mb-4 bg-green-500/10 border border-green-500/50 text-green-500 px-4 py-3 rounded-xl text-sm font-bold flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        {{ session('success') }}
                    </div>
                @endif

                <form wire:submit.prevent="updateProfile" class="space-y-6">
                    <!-- Avatar Upload -->
                    <div class="flex items-center gap-6">
                        <div class="relative group">
                            <div class="w-24 h-24 rounded-full overflow-hidden border-2 border-dashed border-gray-600 group-hover:border-brand-yellow transition-colors bg-dark-900 flex items-center justify-center">
                                @if ($avatar)
                                    <img src="{{ $avatar->temporaryUrl() }}" class="w-full h-full object-cover">
                                @elseif ($existingAvatar)
                                    <img src="{{ Storage::url($existingAvatar) }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-3xl">👤</span>
                                @endif
                            </div>
                            <!-- Loading Indicator -->
                            <div wire:loading wire:target="avatar" class="absolute inset-0 bg-black/50 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-brand-yellow animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-400 mb-2 cursor-pointer hover:text-white transition-colors">
                                <span class="bg-dark-700 px-4 py-2 rounded-lg border border-gray-600 hover:bg-dark-600 hover:border-gray-500 transition-all text-sm font-bold">
                                    Pilih Foto Baru
                                </span>
                                <input type="file" wire:model="avatar" class="hidden" accept="image/*">
                            </label>
                            <p class="text-xs text-gray-500 mt-2">Format: JPG, PNG. Max: 2MB.</p>
                            @error('avatar') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Name -->
                    <div>
                        <label class="text-gray-400 text-sm mb-1 block">Nama Lengkap</label>
                        <input type="text" wire:model="name" class="w-full bg-dark-900 border border-gray-700 rounded-xl px-4 py-2.5 text-white focus:ring-1 focus:ring-brand-yellow focus:border-brand-yellow placeholder-gray-600">
                        @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Email (Readonly) -->
                    <div>
                        <label class="text-gray-400 text-sm mb-1 block">Email (Tidak bisa diubah)</label>
                        <input type="email" wire:model="email" readonly class="w-full bg-dark-900/50 border border-gray-800 rounded-xl px-4 py-2.5 text-gray-500 cursor-not-allowed">
                    </div>

                    <button 
                        type="submit" 
                        wire:loading.attr="disabled"
                        class="w-full bg-brand-yellow text-black font-bold py-2.5 rounded-xl hover:bg-yellow-400 transition-all shadow-lg shadow-brand-yellow/20"
                    >
                        <span wire:loading.remove wire:target="updateProfile">Simpan Perubahan</span>
                        <span wire:loading wire:target="updateProfile">Menyimpan...</span>
                    </button>
                </form>
            </div>

            <!-- Right: Change Password -->
            <div class="bg-dark-800 rounded-2xl p-6 border border-gray-700/50 h-fit">
                <h3 class="text-white font-bold text-lg mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-brand-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 0 00-2-2H6a2 0 00-2 2v6a2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    Ganti Password
                </h3>

                @if (session('password_success'))
                    <div class="mb-4 bg-green-500/10 border border-green-500/50 text-green-500 px-4 py-3 rounded-xl text-sm font-bold flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        {{ session('password_success') }}
                    </div>
                @endif

                <form wire:submit.prevent="updatePassword" class="space-y-4">
                    <!-- Current Password -->
                    <div>
                        <label class="text-gray-400 text-sm mb-1 block">Password Saat Ini</label>
                        <input type="password" wire:model="current_password" class="w-full bg-dark-900 border border-gray-700 rounded-xl px-4 py-2.5 text-white focus:ring-1 focus:ring-brand-yellow focus:border-brand-yellow placeholder-gray-600">
                        @error('current_password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- New Password -->
                    <div>
                        <label class="text-gray-400 text-sm mb-1 block">Password Baru</label>
                        <input type="password" wire:model="new_password" class="w-full bg-dark-900 border border-gray-700 rounded-xl px-4 py-2.5 text-white focus:ring-1 focus:ring-brand-yellow focus:border-brand-yellow placeholder-gray-600">
                        @error('new_password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Confirm New Password -->
                    <div>
                        <label class="text-gray-400 text-sm mb-1 block">Konfirmasi Password Baru</label>
                        <input type="password" wire:model="new_password_confirmation" class="w-full bg-dark-900 border border-gray-700 rounded-xl px-4 py-2.5 text-white focus:ring-1 focus:ring-brand-yellow focus:border-brand-yellow placeholder-gray-600">
                    </div>

                    <button 
                        type="submit" 
                        wire:loading.attr="disabled"
                        class="w-full bg-dark-700 text-white font-bold py-2.5 rounded-xl border border-gray-600 hover:bg-dark-600 transition-all"
                    >
                         <span wire:loading.remove wire:target="updatePassword">Update Password</span>
                         <span wire:loading wire:target="updatePassword">Updating...</span>
                    </button>
                    
                    <p class="text-xs text-gray-500 mt-2 text-center">
                        Pastikan password baru Anda aman dan mudah diingat.
                    </p>
                </form>
            </div>
            </div>

            <!-- Security PIN (New Phase 8) -->
            <div class="col-span-1 md:col-span-2 bg-dark-800 rounded-2xl p-6 border border-gray-700/50 mt-4">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                    <h3 class="text-white font-bold text-lg flex items-center gap-2">
                        <svg class="w-5 h-5 text-brand-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-1.173-1.125A12.054 12.054 0 0110 11m12 0c0 3.517-1.009 6.799-2.753 9.571m-1.173-1.125A12.054 12.054 0 0122 11M12 11V7a4 4 0 00-8 0v4h8z"></path></svg>
                        Security PIN Admin
                    </h3>
                    @if(auth()->user()->is_admin)
                        <span class="px-3 py-1 bg-red-500/10 text-red-500 text-[10px] font-bold uppercase rounded-full border border-red-500/20">Wajib untuk Admin</span>
                    @endif
                </div>

                @if (session('pin_success'))
                    <div class="mb-4 bg-green-500/10 border border-green-500/50 text-green-500 px-4 py-3 rounded-xl text-sm font-bold flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        {{ session('pin_success') }}
                    </div>
                @endif

                <form wire:submit.prevent="updateSecurityPin" class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
                    <div class="md:col-span-2">
                        <label class="text-gray-400 text-sm mb-1 block">Security PIN (6 Digit Angka)</label>
                        <div class="relative">
                            <input type="password" maxlength="6" wire:model="security_pin" placeholder="Masukkan 6 digit angka" class="w-full bg-dark-900 border border-gray-700 rounded-xl px-4 py-2.5 text-white focus:ring-1 focus:ring-brand-yellow focus:border-brand-yellow tracking-[1em] font-black text-center placeholder:tracking-normal placeholder:font-normal">
                            <div class="absolute inset-y-0 right-4 flex items-center text-gray-500 text-xs">
                                {{ strlen($security_pin) }}/6
                            </div>
                        </div>
                        @error('security_pin') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        <p class="text-[10px] text-gray-500 mt-2 italic">
                            PIN ini nantinya akan diminta saat Bapak login ke Dashboard Admin untuk keamanan tambahan.
                        </p>
                    </div>

                    <button 
                        type="submit" 
                        wire:loading.attr="disabled"
                        class="w-full bg-brand-yellow text-black font-bold py-2.5 rounded-xl hover:bg-yellow-400 transition-all shadow-lg shadow-brand-yellow/20"
                    >
                         <span wire:loading.remove wire:target="updateSecurityPin">Update PIN</span>
                         <span wire:loading wire:target="updateSecurityPin">Updating...</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

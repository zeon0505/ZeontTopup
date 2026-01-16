<div class="p-6 space-y-6">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-black text-white italic uppercase tracking-wider">Pengaturan Situs</h1>
            <p class="text-gray-400 mt-1">Kelola identitas dan konfigurasi global ZeonGame</p>
        </div>
        <button wire:click="saveSettings" wire:loading.attr="disabled" class="px-8 py-3 bg-brand-yellow text-black font-black rounded-xl hover:bg-yellow-400 transition-all flex items-center gap-2 group">
            <span wire:loading.remove>Simpan Perubahan</span>
            <span wire:loading class="flex items-center gap-2">
                <svg class="animate-spin h-5 w-5 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                Processing...
            </span>
            <svg wire:loading.remove class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- General Settings -->
        <div class="bg-dark-800/50 backdrop-blur-xl border border-gray-700/50 rounded-3xl p-8 space-y-6">
            <h2 class="text-xl font-black text-white italic flex items-center gap-3 mb-2 uppercase">
                <div class="w-10 h-10 rounded-xl bg-indigo-500/20 flex items-center justify-center text-indigo-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                Identitas Utama
            </h2>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-bold text-gray-400 mb-2 uppercase tracking-tighter">Nama Situs</label>
                    <input type="text" wire:model="settings.site_name" class="w-full bg-dark-900 border border-gray-700 rounded-xl text-white px-4 py-3 focus:ring-1 focus:ring-brand-yellow focus:border-brand-yellow transition-all">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-400 mb-2 uppercase tracking-tighter">Deskripsi Situs</label>
                    <textarea wire:model="settings.site_description" rows="3" class="w-full bg-dark-900 border border-gray-700 rounded-xl text-white px-4 py-3 focus:ring-1 focus:ring-brand-yellow focus:border-brand-yellow transition-all"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-400 mb-2 uppercase tracking-tighter">Site Logo</label>
                    <div class="flex items-center gap-4">
                        @if($settings['site_logo'])
                            <img src="{{ Storage::url($settings['site_logo']) }}" class="h-16 w-auto rounded-lg bg-dark-900 border border-gray-700">
                        @else
                            <div class="h-16 w-16 bg-dark-900 rounded-lg border border-dashed border-gray-700 flex items-center justify-center text-gray-600">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        @endif
                        <input type="file" wire:model="new_logo" class="text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-slate-700 file:text-white hover:file:bg-slate-600">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-400 mb-2 uppercase tracking-tighter">Footer Copyright Text</label>
                    <input type="text" wire:model="settings.footer_text" class="w-full bg-dark-900 border border-gray-700 rounded-xl text-white px-4 py-3 focus:ring-1 focus:ring-brand-yellow focus:border-brand-yellow transition-all" placeholder="© 2025 ZeonGame. All rights reserved.">
                </div>
            </div>
        </div>

        <!-- Contact & Social -->
        <div class="bg-dark-800/50 backdrop-blur-xl border border-gray-700/50 rounded-3xl p-8 space-y-6">
            <h2 class="text-xl font-black text-white italic flex items-center gap-3 mb-2 uppercase">
                <div class="w-10 h-10 rounded-xl bg-green-500/20 flex items-center justify-center text-green-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                </div>
                Kontak & Sosial
            </h2>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-bold text-gray-400 mb-2 uppercase tracking-tighter">Support Email</label>
                    <input type="email" wire:model="settings.contact_email" class="w-full bg-dark-900 border border-gray-700 rounded-xl text-white px-4 py-3 focus:ring-1 focus:ring-brand-yellow focus:border-brand-yellow transition-all">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-400 mb-2 uppercase tracking-tighter">WhatsApp Number (Ex: 62812...)</label>
                    <input type="text" wire:model="settings.whatsapp_number" class="w-full bg-dark-900 border border-gray-700 rounded-xl text-white px-4 py-3 focus:ring-1 focus:ring-brand-yellow focus:border-brand-yellow transition-all">
                </div>
                <div class="grid grid-cols-2 gap-4 pt-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1 uppercase">Instagram URL</label>
                        <input type="text" wire:model="settings.instagram_url" class="w-full bg-dark-900 border border-gray-700 rounded-xl text-white px-3 py-2 text-sm focus:ring-1 focus:ring-brand-yellow transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1 uppercase">TikTok URL</label>
                        <input type="text" wire:model="settings.tiktok_url" class="w-full bg-dark-900 border border-gray-700 rounded-xl text-white px-3 py-2 text-sm focus:ring-1 focus:ring-brand-yellow transition-all">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-1 uppercase tracking-tighter">Youtube Channel URL</label>
                    <input type="text" wire:model="settings.youtube_url" class="w-full bg-dark-900 border border-gray-700 rounded-xl text-white px-4 py-2 text-sm focus:ring-1 focus:ring-brand-yellow transition-all">
                </div>
            </div>

            <!-- SEO Block -->
            <div class="pt-6 border-t border-gray-700/50">
                <h3 class="text-sm font-black text-white italic uppercase mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-brand-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    SEO Keywords
                </h3>
                <textarea wire:model="settings.meta_keywords" rows="3" class="w-full bg-dark-900 border border-gray-700 rounded-xl text-white px-4 py-3 text-sm focus:ring-1 focus:ring-brand-yellow transition-all" placeholder="game, topup, murah, diamond, voucher..."></textarea>
            </div>
        </div>

        <!-- Advanced: Maintenance & Popup -->
        <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Maintenance Mode -->
            <div class="bg-dark-800/50 backdrop-blur-xl border border-red-500/20 rounded-3xl p-8 space-y-6">
                <h2 class="text-xl font-black text-white italic flex items-center gap-3 mb-2 uppercase">
                    <div class="w-10 h-10 rounded-xl bg-red-500/20 flex items-center justify-center text-red-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    Maintenance Mode
                </h2>
                <div class="flex items-center justify-between p-4 bg-red-500/5 border border-red-500/10 rounded-2xl">
                    <div>
                        <p class="text-white font-bold">Aktifkan Mode Perawatan</p>
                        <p class="text-xs text-gray-500">Website hanya bisa diakses oleh administrator.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model="settings.maintenance_mode" true-value="1" false-value="0" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-500"></div>
                    </label>
                </div>
            </div>

            <!-- Popup Promo -->
            <div class="bg-dark-800/50 backdrop-blur-xl border border-indigo-500/20 rounded-3xl p-8 space-y-6">
                <h2 class="text-xl font-black text-white italic flex items-center gap-3 mb-2 uppercase">
                    <div class="w-10 h-10 rounded-xl bg-indigo-500/20 flex items-center justify-center text-indigo-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    </div>
                    Popup Promo Beranda
                </h2>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-indigo-500/5 border border-indigo-500/10 rounded-2xl">
                        <div>
                            <p class="text-white font-bold">Tampilkan Popup</p>
                            <p class="text-xs text-gray-500">Muncul saat user pertama kali buka web.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="settings.enable_popup" true-value="1" false-value="0" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-500"></div>
                        </label>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-2 uppercase">Gambar Popup</label>
                        <div class="flex items-center gap-4">
                            @if($settings['popup_image'])
                                <img src="{{ Storage::url($settings['popup_image']) }}" class="h-20 w-auto rounded-xl border border-gray-700">
                            @endif
                            <input type="file" wire:model="new_popup_image" class="text-xs text-gray-400 file:mr-4 file:py-1 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-slate-700 file:text-white hover:file:bg-slate-600">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <livewire:notification-toast />
</div>

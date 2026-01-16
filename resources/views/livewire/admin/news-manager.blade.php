<div class="p-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-black text-white italic tracking-wider uppercase">Pusat Berita & Promo 📢</h1>
            <p class="text-gray-400 mt-1 text-sm italic">Kelola pengumuman, berita, dan promo untuk halaman beranda.</p>
        </div>
        <button wire:click="create" class="bg-brand-yellow text-black px-6 py-3 rounded-xl font-bold hover:bg-yellow-400 transition-all shadow-lg shadow-brand-yellow/20 flex items-center gap-2 transform active:scale-95">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tulis Berita Baru
        </button>
    </div>

    @if (session()->has('success'))
        <div class="mb-4 bg-green-500/10 border border-green-500/50 text-green-500 px-4 py-3 rounded-xl text-sm font-bold flex items-center gap-2 animate-bounce">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-dark-800 rounded-3xl border border-gray-700/50 overflow-hidden shadow-2xl">
        <div class="p-4 bg-dark-900/50 border-b border-gray-700/50">
            <input type="text" wire:model.live="search" placeholder="Cari judul berita..." class="w-full md:w-80 bg-dark-800 border-gray-700 rounded-xl text-white focus:ring-brand-yellow text-sm">
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-dark-900/50 text-gray-400 text-xs uppercase tracking-widest">
                    <tr>
                        <th class="px-6 py-4 font-bold">Preview</th>
                        <th class="px-6 py-4 font-bold">Judul & Slug</th>
                        <th class="px-6 py-4 font-bold">Status</th>
                        <th class="px-6 py-4 font-bold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700/50">
                    @forelse($newsList as $item)
                        <tr class="hover:bg-dark-700/30 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="w-20 h-12 rounded-lg bg-dark-900 border border-gray-700 overflow-hidden">
                                    @if($item->image)
                                        <img src="{{ Storage::url($item->image) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-[10px] text-gray-600">NO IMG</div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-white font-bold group-hover:text-brand-yellow transition-colors">{{ $item->title }}</div>
                                <div class="text-[10px] text-gray-500 italic">{{ $item->slug }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold w-fit {{ $item->is_featured ? 'bg-yellow-500/10 text-yellow-500 border border-yellow-500/20' : 'bg-gray-800 text-gray-400' }}">
                                        {{ $item->is_featured ? 'FEATURED' : 'NORMAL' }}
                                    </span>
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold w-fit {{ $item->is_active ? 'bg-green-500/10 text-green-500' : 'bg-red-500/10 text-red-500' }}">
                                        {{ $item->is_active ? 'PUBLISHED' : 'DRAFT' }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <button wire:click="edit('{{ $item->id }}')" class="p-2 text-blue-400 hover:bg-blue-500/10 rounded-lg transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <button onclick="confirm('Yakin ingin menghapus?') || event.stopImmediatePropagation()" wire:click="delete('{{ $item->id }}')" class="p-2 text-red-400 hover:bg-red-500/10 rounded-lg transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500 italic">Belum ada berita.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-700/50">
            {{ $newsList->links() }}
        </div>
    </div>

    <!-- Modal -->
    @if($showModal)
    <div class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/80 backdrop-blur-sm" wire:click="$set('showModal', false)"></div>
        <div class="relative bg-dark-800 w-full max-w-2xl rounded-3xl border border-gray-700 shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-200">
            <div class="p-6 border-b border-gray-700/50 flex items-center justify-between">
                <h3 class="text-xl font-bold text-white italic uppercase">{{ $news_id ? 'Edit Berita' : 'Tulis Berita' }}</h3>
                <button wire:click="$set('showModal', false)" class="text-gray-400 hover:text-white">&times;</button>
            </div>
            <form wire:submit.prevent="save" class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Judul Berita</label>
                        <input type="text" wire:model="title" class="w-full bg-dark-900 border-gray-700 rounded-xl text-white focus:ring-brand-yellow">
                        @error('title') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Gambar Banner</label>
                        <input type="file" wire:model="image" class="w-full text-xs text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-black file:bg-dark-700 file:text-brand-yellow hover:file:bg-dark-600">
                        @error('image') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        @if ($image)
                            <img src="{{ $image->temporaryUrl() }}" class="mt-2 h-20 rounded-lg">
                        @elseif($existingImage)
                            <img src="{{ Storage::url($existingImage) }}" class="mt-2 h-20 rounded-lg opacity-50">
                        @endif
                    </div>

                    <div class="flex flex-col gap-4 justify-center">
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="checkbox" wire:model="is_featured" class="rounded border-gray-700 bg-dark-900 text-brand-yellow focus:ring-brand-yellow">
                            <span class="text-sm text-gray-300 group-hover:text-white font-bold">Jadikan Featured</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="checkbox" wire:model="is_active" class="rounded border-gray-700 bg-dark-900 text-brand-yellow focus:ring-brand-yellow">
                            <span class="text-sm text-gray-300 group-hover:text-white font-bold">Status Published</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Konten Berita</label>
                    <textarea wire:model="content" rows="6" class="w-full bg-dark-900 border-gray-700 rounded-xl text-white focus:ring-brand-yellow"></textarea>
                    @error('content') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" wire:click="$set('showModal', false)" class="px-6 py-2.5 rounded-xl text-gray-400 font-bold hover:bg-gray-800 transition-all">Batal</button>
                    <button type="submit" class="px-8 py-2.5 rounded-xl bg-brand-yellow text-black font-black hover:bg-yellow-400 transition-all shadow-lg shadow-brand-yellow/20">
                        {{ $news_id ? 'Update Berita ⚡' : 'Publish Berita 🚀' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>

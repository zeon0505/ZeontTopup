<div class="min-h-screen py-12 bg-dark-900">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumbs / Back -->
        <div class="mb-8">
            <a href="{{ url('/') }}" class="inline-flex items-center text-sm font-bold text-gray-400 hover:text-brand-yellow transition-colors gap-2 group">
                <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/></svg>
                KEMBALI KE BERANDA
            </a>
        </div>

        <article class="bg-dark-800 rounded-3xl overflow-hidden border border-gray-700/50 shadow-2xl">
            <!-- Featured Image -->
            @if($news->image)
                <div class="relative aspect-video overflow-hidden">
                    <img src="{{ Storage::url($news->image) }}" alt="{{ $news->title }}" class="w-full h-full object-cover">
                    <div class="absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-dark-800 to-transparent"></div>
                </div>
            @endif

            <div class="p-8 md:p-12">
                <!-- Meta -->
                <div class="flex items-center gap-4 mb-6">
                    <div class="text-[10px] text-brand-yellow font-black uppercase tracking-[0.2em] bg-brand-yellow/10 px-3 py-1 rounded-full border border-brand-yellow/20">
                        {{ $news->created_at->format('d M Y') }}
                    </div>
                    @if($news->is_featured)
                        <div class="text-[10px] text-white font-black uppercase tracking-[0.2em] bg-red-600 px-3 py-1 rounded-full border border-red-500/20 shadow-lg shadow-red-600/20">
                            HOT PROMO ⚡
                        </div>
                    @endif
                </div>

                <!-- Title -->
                <h1 class="text-3xl md:text-5xl font-black text-white italic uppercase tracking-wider mb-8 leading-tight">
                    {{ $news->title }}
                </h1>

                <!-- Content -->
                <div class="prose prose-invert prose-brand max-w-none text-gray-300 leading-relaxed">
                    {!! nl2br(e($news->content)) !!}
                </div>

                <!-- Sharing / Footer -->
                <div class="mt-12 pt-12 border-t border-gray-700/50 flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="flex items-center gap-4">
                        <span class="text-sm font-bold text-gray-500 uppercase tracking-widest">BAGIKAN:</span>
                        <div class="flex gap-2">
                             <a href="https://wa.me/?text={{ urlencode($news->title . ' ' . url()->current()) }}" target="_blank" class="w-10 h-10 rounded-full bg-green-500/10 text-green-500 flex items-center justify-center hover:bg-green-500 hover:text-white transition-all shadow-lg">
                                <i class="fab fa-whatsapp"></i>
                             </a>
                             <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" target="_blank" class="w-10 h-10 rounded-full bg-blue-500/10 text-blue-500 flex items-center justify-center hover:bg-blue-500 hover:text-white transition-all shadow-lg">
                                <i class="fab fa-facebook-f"></i>
                             </a>
                        </div>
                    </div>
                    
                    <a href="{{ route('order.show', \App\Models\Game::first()->slug ?? 'mobile-legends') }}" class="inline-flex items-center justify-center px-8 py-3 bg-brand-yellow text-black font-black italic uppercase tracking-wider rounded-2xl hover:bg-yellow-400 transition-all shadow-xl shadow-yellow-500/20 hover:scale-105 transform">
                        TOP UP SEKARANG ⚡
                    </a>
                </div>
            </div>
        </article>
        
        <!-- Related News (Optional) -->
        <div class="mt-16">
            <h2 class="text-2xl font-black text-white italic uppercase tracking-wider mb-8">BERITA LAINNYA 📢</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @php
                    $relatedNews = \App\Models\News::where('id', '!=', $news->id)->where('is_active', true)->latest()->take(2)->get();
                @endphp
                @foreach($relatedNews as $related)
                    <a href="{{ route('news.show', $related->slug) }}" class="group bg-dark-800 p-6 rounded-3xl border border-gray-700/50 hover:border-brand-yellow/50 transition-all flex gap-6 items-center shadow-xl">
                        @if($related->image)
                            <img src="{{ Storage::url($related->image) }}" class="w-20 h-20 rounded-2xl object-cover shadow-lg" alt="{{ $related->title }}">
                        @endif
                        <div>
                            <div class="text-[9px] text-brand-yellow font-black uppercase tracking-widest mb-1">{{ $related->created_at->format('d M Y') }}</div>
                            <h3 class="text-white font-bold group-hover:text-brand-yellow transition-colors line-clamp-1 italic">{{ $related->title }}</h3>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>

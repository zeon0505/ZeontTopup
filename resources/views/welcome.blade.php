<x-layouts.app>
    <!-- Hero Section / Carousel -->
    <!-- Hero Section / Carousel -->
    <div class="relative py-8 bg-slate-900" x-data="{ 
            activeSlide: 0,
            slides: {{ $banners->map(fn($b) => ['image' => Storage::url($b->image), 'title' => $b->title, 'desc' => $b->description, 'btn_text' => $b->button_text, 'btn_url' => $b->button_url]) }},
            timer: null,
            init() {
                if(this.slides.length > 1) {
                    this.startAutoplay();
                }
            },
            next() {
                this.activeSlide = this.activeSlide === this.slides.length - 1 ? 0 : this.activeSlide + 1;
            },
            prev() {
                this.activeSlide = this.activeSlide === 0 ? this.slides.length - 1 : this.activeSlide - 1;
            },
            goTo(index) {
                this.activeSlide = index;
                this.resetTimer();
            },
            startAutoplay() {
                this.timer = setInterval(() => this.next(), 5000);
            },
            resetTimer() {
                clearInterval(this.timer);
                this.startAutoplay();
            }
        }">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Carousel Container -->
            <div data-aos="zoom-in" class="relative overflow-hidden rounded-2xl aspect-[21/9] bg-slate-800 border border-white/10 group">
                
                <!-- Slides -->
                <template x-for="(slide, index) in slides" :key="index">
                    <div x-show="activeSlide === index"
                         x-transition:enter="transition ease-out duration-700"
                         x-transition:enter-start="opacity-0 scale-105"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-300"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute inset-0 w-full h-full">
                        
                        <!-- Image -->
                        <img :src="slide.image" 
                             :alt="slide.title" 
                             class="object-cover w-full h-full opacity-60">
                        
                        <!-- Text Overlay -->
                        <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-t from-slate-900/90 via-slate-900/40 to-transparent">
                            <div class="text-center max-w-2xl px-4">
                                <h1 x-text="slide.title" class="text-3xl font-extrabold text-white md:text-5xl lg:text-6xl italic leading-tight drop-shadow-lg"></h1>
                                <p x-text="slide.desc" class="mt-4 text-base md:text-xl text-gray-200 drop-shadow-md"></p>
                                
                                <template x-if="slide.btn_text && slide.btn_url">
                                    <div class="mt-8">
                                        <a :href="slide.btn_url" class="inline-flex items-center justify-center px-8 py-3 text-base font-bold text-black transition-transform bg-brand-yellow rounded-full hover:bg-yellow-400 hover:scale-105 shadow-[0_0_20px_rgba(250,204,21,0.3)]">
                                            <span x-text="slide.btn_text"></span>
                                        </a>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- Loading / Empty State -->
                <template x-if="slides.length === 0">
                     <div class="absolute inset-0 flex items-center justify-center bg-slate-800">
                        <div class="text-center">
                            <h1 class="text-4xl font-extrabold text-white md:text-6xl italic">
                                TOP UP <span class="text-brand-yellow">TERCEPAT</span>
                            </h1>
                            <p class="mt-4 text-xl text-gray-300">Murah, Aman, dan Terpercaya</p>
                        </div>
                    </div>
                </template>


                <!-- Controls (Only if > 1 slide) -->
                <template x-if="slides.length > 1">
                    <div>
                         <!-- Prev Button -->
                        <button @click="prev(); resetTimer()" class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-black/30 backdrop-blur-sm flex items-center justify-center text-white hover:bg-brand-yellow hover:text-black transition-all opacity-0 group-hover:opacity-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        </button>
                        
                        <!-- Next Button -->
                        <button @click="next(); resetTimer()" class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-black/30 backdrop-blur-sm flex items-center justify-center text-white hover:bg-brand-yellow hover:text-black transition-all opacity-0 group-hover:opacity-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </button>

                         <!-- Carousel Indicators -->
                        <div class="absolute flex gap-2 transform -translate-x-1/2 bottom-4 left-1/2 z-20">
                            <template x-for="(slide, index) in slides" :key="index">
                                <button @click="goTo(index)" 
                                        class="w-2.5 h-2.5 rounded-full transition-all duration-300"
                                        :class="activeSlide === index ? 'bg-brand-yellow w-8' : 'bg-white/50 hover:bg-white'">
                                </button>
                            </template>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- Running Text / Marquee (Optional Polish) -->
    <div class="border-y border-white/5 bg-slate-900/50">
        <div class="px-4 py-3 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex items-center gap-4 text-sm text-gray-400">
                <span class="px-2 py-0.5 text-xs font-bold text-black rounded bg-brand-yellow">INFO</span>
                <span>Selamat datang di ZeonGame! Nikmati layanan top up 24 jam non-stop.</span>
            </div>
        </div>
    </div>

    <!-- Flash Sale Section -->
    @if($flashSales->count() > 0)
        @php
            // Get earliest end time for countdown
            $endTime = $flashSales->first()->end_time->format('M d, Y H:i:s');
        @endphp
        <div class="py-12 bg-dark-800 border-y border-brand-yellow/10" 
             x-data="{
                endTime: new Date('{{ $endTime }}').getTime(),
                now: new Date().getTime(),
                timeLeft: 0,
                days: 0,
                hours: 0,
                minutes: 0,
                seconds: 0,
                updateTimer() {
                    this.now = new Date().getTime();
                    this.timeLeft = this.endTime - this.now;

                    if (this.timeLeft > 0) {
                        this.days = Math.floor(this.timeLeft / (1000 * 60 * 60 * 24));
                        this.hours = Math.floor((this.timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        this.minutes = Math.floor((this.timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                        this.seconds = Math.floor((this.timeLeft % (1000 * 60)) / 1000);
                    }
                },
                init() {
                    this.updateTimer();
                    setInterval(() => this.updateTimer(), 1000);
                }
             }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                 <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
                    <!-- Title -->
                    <div class="flex items-center gap-4">
                        <div class="bg-red-600 text-white font-black italic text-2xl px-4 py-2 -skew-x-12 transform shadow-[0_0_20px_rgba(220,38,38,0.5)] border border-white/20">
                            <span class="block skew-x-12">FLASH SALE ⚡</span>
                        </div>
                        <div class="hidden md:block h-px w-20 bg-gradient-to-r from-red-600 to-transparent"></div>
                    </div>

                    <!-- Countdown -->
                    <div class="flex items-center gap-2 text-white font-mono text-xl md:text-2xl">
                        <span class="text-sm font-sans text-gray-400 mr-2 uppercase tracking-wider">Ends in:</span>
                        <div class="bg-dark-900 border border-red-500/30 rounded px-2 py-1 shadow-lg shadow-red-900/20">
                            <span x-text="hours.toString().padStart(2, '0')">00</span>
                        </div>
                        <span class="text-red-500 animate-pulse">:</span>
                        <div class="bg-dark-900 border border-red-500/30 rounded px-2 py-1 shadow-lg shadow-red-900/20">
                            <span x-text="minutes.toString().padStart(2, '0')">00</span>
                        </div>
                        <span class="text-red-500 animate-pulse">:</span>
                        <div class="bg-dark-900 border border-red-500/30 rounded px-2 py-1 shadow-lg shadow-red-900/20">
                            <span x-text="seconds.toString().padStart(2, '0')">00</span>
                        </div>
                    </div>
                 </div>

                 <!-- Grid -->
                 <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
                    @foreach($flashSales as $sale)
                        <a href="{{ route('order.show', $sale->product->game->slug) }}?product={{ $sale->product->id }}" 
                           class="block relative group bg-dark-900 border border-gray-700 hover:border-brand-yellow/50 rounded-xl overflow-hidden transition-all hover:shadow-[0_0_20px_rgba(250,204,21,0.15)] hover:-translate-y-1">
                            
                            <!-- Badges -->
                            <div class="absolute top-2 right-2 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded shadow-lg z-10 animate-pulse">
                                -{{ round((($sale->product->price - $sale->discount_price) / $sale->product->price) * 100) }}%
                            </div>

                            <!-- Image -->
                            <div class="aspect-square relative overflow-hidden bg-dark-800">
                                @if(!empty($sale->product->game->image))
                                    <img src="{{ Storage::url($sale->product->game->image) }}" alt="{{ $sale->product->game->name }}" 
                                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="hidden w-full h-full absolute inset-0 flex items-center justify-center bg-dark-700">
                                        <span class="text-4xl font-black text-gray-600 group-hover:text-brand-yellow transition-colors">
                                            {{ substr($sale->product->game->name ?? 'G', 0, 1) }}
                                        </span>
                                    </div>
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-dark-700">
                                        <span class="text-4xl font-black text-gray-600 group-hover:text-brand-yellow transition-colors">
                                            {{ substr($sale->product->game->name ?? 'G', 0, 1) }}
                                        </span>
                                    </div>
                                @endif
                                
                                <!-- Overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t from-dark-900 via-transparent to-transparent opacity-80 pointer-events-none"></div>
                                <div class="absolute bottom-2 left-2 right-2 pointer-events-none">
                                     <h3 class="text-white text-sm font-bold leading-tight line-clamp-2 drop-shadow-md">{{ $sale->product->name }}</h3>
                                </div>
                            </div>
                            
                            <!-- Price -->
                            <div class="p-4">
                                <div class="text-xs text-gray-500 line-through mb-0.5">Rp {{ number_format($sale->product->price, 0, ',', '.') }}</div>
                                <div class="text-brand-yellow font-bold text-lg">Rp {{ number_format($sale->discount_price, 0, ',', '.') }}</div>
                                
                                {{-- Progress Bar / Stock (Optional fake stock logic) --}}
                                <div class="mt-3 w-full bg-gray-800 rounded-full h-1.5 overflow-hidden">
                                    <div class="bg-gradient-to-r from-red-500 to-orange-500 h-full w-[85%] rounded-full relative">
                                         <div class="absolute top-0 right-0 bottom-0 w-10 bg-white/20 -skew-x-12 animate-shimmer"></div>
                                    </div>
                                </div>
                                <div class="mt-1 flex justify-between text-[10px] text-gray-400">
                                    <span>Tersedia</span>
                                    <span class="text-red-400 font-bold">Segera Habis!</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                 </div>
            </div>
        </div>
    @endif
    
    <!-- Special Features Grid -->
    <div class="py-12 bg-slate-950 border-t border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-4 mb-8">
                <h2 class="text-xl font-black text-white italic truncate uppercase">SPECIAL FEATURES 🚀</h2>
                <div class="flex-1 h-px bg-white/5"></div>
            </div>
            
            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-6 gap-6">
                <!-- Zeon Flappy Card -->
                <a href="{{ route('minigame') }}" 
                   data-aos="zoom-in"
                   class="group relative block aspect-square rounded-[2.5rem] bg-slate-900 border border-white/5 hover:border-brand-yellow/50 transition-all duration-300 hover:-translate-y-2 shadow-2xl">
                    <div class="absolute inset-0 bg-gradient-to-br from-brand-yellow/5 to-transparent"></div>
                    <div class="absolute inset-0 flex flex-col items-center justify-center p-6 text-center">
                        <div class="w-16 h-16 bg-brand-yellow rounded-2xl flex items-center justify-center shadow-[0_0_30px_rgba(250,204,21,0.2)] mb-4 group-hover:scale-110 transition-transform animate-bounce-slow">
                            <svg class="w-10 h-10 text-slate-950" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12,2L4.5,20.29L5.21,21L12,18L18.79,21L19.5,20.29L12,2Z" />
                            </svg>
                        </div>
                        <h3 class="text-white font-black italic text-sm group-hover:text-brand-yellow transition-colors leading-tight">ZEON<br>FLAPPY</h3>
                        <p class="text-[9px] text-gray-500 font-bold uppercase tracking-[0.2em] mt-2">Play & Win</p>
                    </div>
                    <!-- Status Badge -->
                    <div class="absolute top-5 right-5 pb-1">
                        <span class="relative flex h-2 w-2">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-yellow opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2 w-2 bg-brand-yellow"></span>
                        </span>
                    </div>
                </a>

                <!-- Calculator Card -->
                <a href="{{ route('calculator.index') }}" 
                   data-aos="zoom-in" data-aos-delay="100"
                   class="group relative block aspect-square rounded-[2.5rem] bg-slate-900 border border-white/5 hover:border-blue-500/50 transition-all duration-300 hover:-translate-y-2 shadow-2xl">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-transparent"></div>
                    <div class="absolute inset-0 flex flex-col items-center justify-center p-6 text-center">
                        <div class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center shadow-[0_0_30px_rgba(37,99,235,0.2)] mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" stroke-width="2"/>
                            </svg>
                        </div>
                        <h3 class="text-white font-black italic text-sm group-hover:text-blue-400 transition-colors leading-tight">CALKU<br>LATOR</h3>
                        <p class="text-[9px] text-gray-500 font-bold uppercase tracking-[0.2em] mt-2">Free Tools</p>
                    </div>
                </a>

                <!-- Leaderboard Card -->
                <a href="{{ route('leaderboard') }}" 
                   data-aos="zoom-in" data-aos-delay="200"
                   class="group relative block aspect-square rounded-[2.5rem] bg-slate-900 border border-white/5 hover:border-indigo-500/50 transition-all duration-300 hover:-translate-y-2 shadow-2xl">
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/5 to-transparent"></div>
                    <div class="absolute inset-0 flex flex-col items-center justify-center p-6 text-center">
                        <div class="w-16 h-16 bg-indigo-600 rounded-2xl flex items-center justify-center shadow-[0_0_30px_rgba(79,70,229,0.2)] mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" stroke-width="2"/>
                            </svg>
                        </div>
                        <h3 class="text-white font-black italic text-sm group-hover:text-indigo-400 transition-colors leading-tight">LEADER<br>BOARD</h3>
                        <p class="text-[9px] text-gray-500 font-bold uppercase tracking-[0.2em] mt-2">Top Player</p>
                    </div>
                </a>

                <!-- Track Order Card -->
                <a href="{{ route('transaction.search') }}" 
                   data-aos="zoom-in" data-aos-delay="300"
                   class="group relative block aspect-square rounded-[2.5rem] bg-slate-900 border border-white/5 hover:border-green-500/50 transition-all duration-300 hover:-translate-y-2 shadow-2xl">
                    <div class="absolute inset-0 bg-gradient-to-br from-green-500/5 to-transparent"></div>
                    <div class="absolute inset-0 flex flex-col items-center justify-center p-6 text-center">
                        <div class="w-16 h-16 bg-green-600 rounded-2xl flex items-center justify-center shadow-[0_0_30px_rgba(22,163,74,0.2)] mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2"/>
                            </svg>
                        </div>
                        <h3 class="text-white font-black italic text-sm group-hover:text-green-400 transition-colors leading-tight">TRACK<br>ORDER</h3>
                        <p class="text-[9px] text-gray-500 font-bold uppercase tracking-[0.2em] mt-2">Check Status</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- News & Promos Section -->
    <div class="py-16 bg-dark-900 overflow-hidden border-t border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
                <div>
                    <h2 class="text-3xl md:text-4xl font-black text-white italic uppercase tracking-wider underline decoration-brand-yellow decoration-8 underline-offset-8">BERITA & PROMO 📢</h2>
                    <p class="text-gray-400 mt-6 max-w-xl">Dapatkan informasi terbaru mengenai update game, promo top up, dan event menarik di ZeonGame.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-y-20 lg:gap-12">
                <div class="lg:col-span-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @forelse($news as $article)
                            <div data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}" class="group bg-dark-800/40 backdrop-blur-md rounded-[2rem] overflow-hidden border border-white/5 hover:border-brand-yellow/30 transition-all duration-500 hover:-translate-y-2 shadow-2xl relative">
                                <div class="relative aspect-[16/10] overflow-hidden">
                                    @if($article->image)
                                        <img src="{{ Storage::url($article->image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-dark-700 to-dark-900 flex items-center justify-center text-gray-700 font-black italic tracking-tighter text-4xl">ZEONGAME</div>
                                    @endif
                                    
                                    <!-- Overlay Gradient -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-dark-900 via-dark-900/20 to-transparent opacity-60"></div>
                                    
                                    @if($article->is_featured)
                                        <div class="absolute top-5 left-5 bg-brand-yellow text-black text-[10px] font-black px-4 py-1.5 rounded-full uppercase tracking-[0.2em] shadow-[0_0_20px_rgba(250,204,21,0.4)] z-10 animate-pulse">FEATURED</div>
                                    @endif
                                </div>
                                <div class="p-8 relative">
                                    <div class="flex items-center gap-3 mb-4">
                                        <div class="w-8 h-[1px] bg-brand-yellow/50"></div>
                                        <span class="text-[10px] text-brand-yellow font-black uppercase tracking-[0.3em]">{{ $article->created_at->format('d M Y') }}</span>
                                    </div>
                                    <h3 class="text-xl font-bold text-white group-hover:text-brand-yellow transition-colors line-clamp-2 leading-tight mb-4 italic tracking-tight">{{ $article->title }}</h3>
                                    <p class="text-gray-400 text-sm line-clamp-2 mb-8 leading-relaxed font-medium">{{ Str::limit(strip_tags($article->content), 100) }}</p>
                                    
                                    <a href="{{ route('news.show', $article->slug) }}" class="inline-flex items-center text-[10px] font-black text-white hover:text-brand-yellow transition-all gap-3 group/btn uppercase tracking-[0.2em]">
                                        Explore Article
                                        <div class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center group-hover/btn:bg-brand-yellow group-hover/btn:text-black transition-all">
                                            <svg class="w-3 h-3 transform group-hover/btn:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full py-20 text-center bg-white/[0.02] rounded-[2.5rem] border border-dashed border-white/10 backdrop-blur-sm group/empty">
                                 <div class="w-20 h-20 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-6 border border-white/10 group-hover/empty:scale-110 transition-transform duration-500">
                                      <svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2zM15 4v4h4" /></svg>
                                 </div>
                                 <h4 class="text-white font-black italic uppercase tracking-widest mb-2">Belum Ada Berita</h4>
                                 <p class="text-gray-500 text-xs font-bold uppercase tracking-widest max-w-xs mx-auto leading-relaxed">Nantikan update terbaru seputar promo dan event menarik dari ZeonGame!</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Activity Feed Column -->
                <div class="lg:col-span-4" data-aos="fade-left">
                    <livewire:activity-feed />
                </div>
            </div>
        </div>
    </div>


            <!-- Popular Games Component -->
            <livewire:home.popular-games />

    <!-- Popup Promo Modal -->
    @if(\App\Models\SiteSetting::get('enable_popup') === '1' && $popupImg = \App\Models\SiteSetting::get('popup_image'))
        <div x-data="{ showPopup: false }" 
             x-init="setTimeout(() => { if(!sessionStorage.getItem('zeon_popup_shown')) { showPopup = true; } }, 2000)"
             x-show="showPopup"
             class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             style="display: none;">
            
            <div @click.away="showPopup = false; sessionStorage.setItem('zeon_popup_shown', 'true')" 
                 class="relative max-w-lg w-full bg-dark-800 rounded-3xl overflow-hidden shadow-[0_0_50px_rgba(250,204,21,0.2)] border border-brand-yellow/20"
                 x-transition:enter="transition ease-out duration-500 delay-100"
                 x-transition:enter-start="opacity-0 scale-90 translate-y-8"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0">
                
                <!-- Close Button -->
                <button @click="showPopup = false; sessionStorage.setItem('zeon_popup_shown', 'true')" 
                        class="absolute top-4 right-4 z-10 w-10 h-10 rounded-full bg-black/50 text-white flex items-center justify-center hover:bg-brand-yellow hover:text-black transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>

                <!-- Image -->
                <div class="relative aspect-square md:aspect-[4/5] bg-dark-900">
                    <img src="{{ Storage::url($popupImg) }}" class="w-full h-full object-cover" alt="Promo">
                    <div class="absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-dark-800 to-transparent"></div>
                </div>

                <!-- Footer Action -->
                <div class="p-6 pt-0 text-center relative z-10 -mt-20">
                    <button @click="showPopup = false; sessionStorage.setItem('zeon_popup_shown', 'true')" 
                            class="w-full py-4 bg-brand-yellow text-black font-black italic uppercase tracking-wider rounded-2xl hover:bg-yellow-400 transition-all shadow-xl shadow-yellow-500/20 active:scale-95 transform">
                        AMBIL PROMO SEKARANG! ⚡
                    </button>
                    <p class="mt-4 text-xs text-gray-500 font-medium">Klik di mana saja untuk menutup</p>
                </div>
            </div>
        </div>
    @endif
</x-layouts.app>

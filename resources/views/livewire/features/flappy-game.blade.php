<div class="py-12 px-4 min-h-screen bg-slate-950">
    <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Game Area -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-slate-900/50 backdrop-blur-xl border border-white/10 rounded-3xl p-6 shadow-2xl overflow-hidden relative group">
                <!-- Header -->
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-white flex items-center gap-2">
                            <span class="p-2 bg-brand-yellow rounded-lg text-slate-900">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </span>
                            Zeon Flappy
                        </h2>
                        <p class="text-gray-400 text-sm mt-1">Gapai skor tertinggi dan menangkan Voucher!</p>
                    </div>
                    <div class="text-right">
                        <div class="text-xs text-gray-500 uppercase tracking-widest font-bold">Skor Tertinggi Anda Hari Ini</div>
                        <div class="text-2xl font-black text-brand-yellow">{{ $userHighScore }}</div>
                    </div>
                </div>

                <!-- Game Canvas Container -->
                <div class="relative aspect-[16/9] w-full bg-slate-950 rounded-2xl border border-white/5 overflow-hidden shadow-inner cursor-pointer" id="game-container" wire:ignore>
                    <canvas id="gameCanvas" class="w-full h-full"></canvas>
                    
                    <!-- Start Overlay -->
                    <div id="start-overlay" class="absolute inset-0 z-20 flex flex-col items-center justify-center bg-slate-950/80 backdrop-blur-sm transition-opacity duration-300">
                        <div class="w-24 h-24 mb-6 animate-bounce">
                             <svg class="text-brand-yellow w-full h-full" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12,2L4.5,20.29L5.21,21L12,18L18.79,21L19.5,20.29L12,2Z" />
                             </svg>
                        </div>
                        <h3 class="text-3xl font-black text-white mb-2">KLIK UNTUK MAIN</h3>
                        <p class="text-gray-400 mb-8 px-8 text-center">Gunakan [Spasi] atau [Klik Mouse] untuk terbang melompati pipa.</p>
                        <button onclick="startGame()" class="px-8 py-3 bg-brand-yellow text-slate-900 font-bold rounded-xl hover:scale-105 transition-transform shadow-[0_0_20px_rgba(250,204,21,0.4)]">
                            Mulai Sekarang
                        </button>
                    </div>

                    <!-- HUD -->
                    <div id="game-hud" class="absolute top-4 left-4 z-10 hidden">
                        <div class="px-4 py-2 bg-slate-900/80 backdrop-blur-md rounded-lg border border-white/10">
                            <span class="text-gray-400 text-xs font-bold mr-2">POIN</span>
                            <span id="current-score" class="text-white text-xl font-black">0</span>
                        </div>
                    </div>
                </div>

                <!-- Instructions -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                    <div class="p-4 rounded-2xl bg-white/5 border border-white/5 flex items-start gap-3">
                        <div class="p-2 bg-indigo-500/20 text-indigo-400 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2"/></svg>
                        </div>
                        <div>
                            <div class="text-white font-bold text-sm">Resets Harian</div>
                            <p class="text-xs text-gray-500">Leaderboard direset setiap jam 00:00 WIB.</p>
                        </div>
                    </div>
                    <div class="p-4 rounded-2xl bg-white/5 border border-white/5 flex items-start gap-3">
                        <div class="p-2 bg-brand-yellow/20 text-brand-yellow rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2"/></svg>
                        </div>
                        <div>
                            <div class="text-white font-bold text-sm">Hadiah Voucher</div>
                            <p class="text-xs text-gray-500">Juara 1 otomatis mendapat Voucher Belanja.</p>
                        </div>
                    </div>
                    <div class="p-4 rounded-2xl bg-white/5 border border-white/5 flex items-start gap-3">
                        <div class="p-2 bg-emerald-500/20 text-emerald-400 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2"/></svg>
                        </div>
                        <div>
                            <div class="text-white font-bold text-sm">Anti Cheat</div>
                            <p class="text-xs text-gray-500">Skor abnormal akan didiskualifikasi.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Leaderboard -->
        <div class="space-y-6">
            <div class="bg-slate-900/50 backdrop-blur-xl border border-white/10 rounded-3xl p-6 shadow-2xl h-full">
                <h3 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-brand-yellow" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    Top Leaders Hari Ini
                </h3>

                <div class="space-y-3" x-on:score-updated.window="$wire.loadData()">
                    @forelse($leaderboard as $index => $score)
                        <div class="flex items-center justify-between p-4 rounded-2xl {{ $index == 0 ? 'bg-gradient-to-r from-brand-yellow/20 to-transparent border border-brand-yellow/30' : 'bg-white/5 border border-white/5' }} transition-all hover:bg-white/10">
                            <div class="flex items-center gap-4">
                                <div class="w-8 h-8 flex items-center justify-center font-black rounded-lg {{ $index == 0 ? 'bg-brand-yellow text-slate-950' : 'text-gray-500 bg-white/5' }}">
                                    {{ $index + 1 }}
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-white">{{ $score->user->name }}</div>
                                    <div class="text-[10px] text-gray-500 uppercase tracking-widest">{{ $score->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                            <div class="text-lg font-black text-white">
                                {{ $score->score }}
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <p class="text-gray-500">Belum ada skor hari ini.<br>Jadilah yang pertama!</p>
                        </div>
                    @endforelse
                </div>

                @if(!auth()->check())
                    <div class="mt-8 p-4 bg-indigo-600/10 border border-indigo-600/30 rounded-2xl text-center">
                        <p class="text-indigo-300 text-sm mb-4">Masuk untuk menyimpan skor Anda!</p>
                        <a href="{{ route('login') }}" class="inline-block px-6 py-2 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-500 transition-colors">Login</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Game Script -->
    <script>
        (function() {
            let canvas, ctx, startOverlay, gameHud, scoreDisplay;
            let gameRunning = false;
            let score = 0;
            let animationId;
            let frame = 0;
            let pipes = [];
            let bird = { x: 50, y: 150, velocity: 0, radius: 12 };

            const GRAVITY = 0.25;
            const FLAP = -4.5;
            const SPAWN_RATE = 90;
            const PIPE_WIDTH = 50;
            const PIPE_GAP = 160;

            function initGame() {
                canvas = document.getElementById('gameCanvas');
                if (!canvas) return;
                ctx = canvas.getContext('2d');
                startOverlay = document.getElementById('start-overlay');
                gameHud = document.getElementById('game-hud');
                scoreDisplay = document.getElementById('current-score');

                resizeCanvas();
                
                // Clear existing listeners to prevent duplication
                window.removeEventListener('resize', resizeCanvas);
                window.addEventListener('resize', resizeCanvas);
                
                // Use a single keydown listener on window
                if (!window.flappyKeyHandler) {
                    window.flappyKeyHandler = (e) => {
                        if (e.code === 'Space') {
                            const currentCanvas = document.getElementById('gameCanvas');
                            if (!currentCanvas) return;
                            
                            if (!gameRunning) window.startGame();
                            else window.flap();
                            e.preventDefault();
                        }
                    };
                    window.addEventListener('keydown', window.flappyKeyHandler);
                }

                canvas.onmousedown = (e) => {
                    if (!gameRunning) window.startGame();
                    else window.flap();
                    e.preventDefault();
                };
            }

            function resizeCanvas() {
                const container = document.getElementById('game-container');
                if (!container || !canvas) return;
                canvas.width = container.clientWidth;
                canvas.height = container.clientHeight;
            }

            window.startGame = function() {
                if (gameRunning) return;
                
                bird = { x: 50, y: canvas.height/2, velocity: 0, radius: 12 };
                pipes = [];
                score = 0;
                frame = 0;
                gameRunning = true;
                
                startOverlay.style.display = 'none';
                gameHud.classList.remove('hidden');
                scoreDisplay.innerText = "0";
                
                gameLoop();
            };

            window.flap = function() {
                if (gameRunning) bird.velocity = FLAP;
            };

            function gameOver() {
                if (!gameRunning) return;
                gameRunning = false;
                cancelAnimationFrame(animationId);
                
                startOverlay.style.display = 'flex';
                startOverlay.classList.remove('opacity-0');
                
                // Submit score to Livewire
                const livewireComponent = window.Livewire.find(
                    document.getElementById('game-container').closest('[wire:id]').getAttribute('wire:id')
                );
                if (livewireComponent) {
                    livewireComponent.submitScore(score);
                }
            }

            function gameLoop() {
                if (!gameRunning) return;

                ctx.clearRect(0, 0, canvas.width, canvas.height);

                bird.velocity += GRAVITY;
                bird.y += bird.velocity;

                if (bird.y + bird.radius > canvas.height || bird.y - bird.radius < 0) {
                    gameOver();
                    return;
                }

                ctx.fillStyle = '#facc15';
                ctx.beginPath();
                ctx.arc(bird.x, bird.y, bird.radius, 0, Math.PI * 2);
                ctx.fill();
                ctx.fillStyle = '#0f172a';
                ctx.beginPath();
                ctx.arc(bird.x + 6, bird.y - 4, 3, 0, Math.PI * 2);
                ctx.fill();

                if (frame % SPAWN_RATE === 0) {
                    const h = Math.random() * (canvas.height - PIPE_GAP - 100) + 50;
                    pipes.push({ x: canvas.width, h: h, passed: false });
                }

                for (let i = pipes.length - 1; i >= 0; i--) {
                    const p = pipes[i];
                    p.x -= 3;

                    ctx.fillStyle = '#334155';
                    ctx.fillRect(p.x, 0, PIPE_WIDTH, p.h);
                    ctx.fillRect(p.x, p.h + PIPE_GAP, PIPE_WIDTH, canvas.height - p.h - PIPE_GAP);

                    if (bird.x + bird.radius > p.x && bird.x - bird.radius < p.x + PIPE_WIDTH) {
                        if (bird.y - bird.radius < p.h || bird.y + bird.radius > p.h + PIPE_GAP) {
                            gameOver();
                            return;
                        }
                    }

                    if (!p.passed && p.x + PIPE_WIDTH < bird.x) {
                        p.passed = true;
                        score++;
                        scoreDisplay.innerText = score;
                    }

                    if (p.x + PIPE_WIDTH < 0) pipes.splice(i, 1);
                }

                frame++;
                animationId = requestAnimationFrame(gameLoop);
            }

            document.addEventListener('livewire:navigated', initGame);
            document.addEventListener('DOMContentLoaded', initGame);
            // Also init on Livewire update just in case, but wire:ignore should handle it
            initGame();
        })();
    </script>
</div>

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
                    
                    <!-- Start/Game Over Overlay -->
                    <div id="start-overlay" class="absolute inset-0 z-20 flex flex-col items-center justify-center bg-slate-950/80 backdrop-blur-sm transition-opacity duration-300">
                        <div id="game-over-content" class="hidden text-center mb-6">
                            <h4 class="text-brand-yellow font-black text-xl uppercase tracking-tighter mb-1">Game Over!</h4>
                            <div id="new-highscore-badge" class="hidden mb-2">
                                <span class="bg-indigo-600 text-white text-[10px] font-black px-2 py-1 rounded-full animate-pulse">NEW HIGH SCORE! 🏆</span>
                            </div>
                            <p class="text-white text-2xl font-black">Selamat! Skor Anda: <span id="final-score" class="text-brand-yellow">0</span></p>
                        </div>

                        <div id="start-content" class="flex flex-col items-center">
                            <div class="w-20 h-20 mb-6 animate-bounce">
                                 <svg class="text-brand-yellow w-full h-full" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12,2L4.5,20.29L5.21,21L12,18L18.79,21L19.5,20.29L12,2Z" />
                                 </svg>
                            </div>
                            <h3 id="start-title" class="text-3xl font-black text-white mb-2">KLIK UNTUK MAIN</h3>
                            <p class="text-gray-400 mb-8 px-8 text-center text-sm">Gunakan [Spasi] atau [Klik Mouse] untuk terbang.</p>
                        </div>

                        <button onclick="startGame()" class="px-10 py-4 bg-brand-yellow text-slate-900 font-black italic rounded-2xl hover:scale-105 transition-transform shadow-[0_10px_30px_rgba(250,204,21,0.3)]">
                            <span id="button-text">MULAI SEKARANG</span>
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
            let clouds = [];
            let bird = { x: 50, y: 150, velocity: 0, radius: 14, rotation: 0 };

            const GRAVITY = 0.22;
            const FLAP = -4.2;
            const SPAWN_RATE = 95;
            const PIPE_WIDTH = 60;
            const PIPE_GAP = 150;

            let userHighScore = {{ $userHighScore }};

            function initGame() {
                canvas = document.getElementById('gameCanvas');
                if (!canvas) return;
                ctx = canvas.getContext('2d');
                startOverlay = document.getElementById('start-overlay');
                gameHud = document.getElementById('game-hud');
                scoreDisplay = document.getElementById('current-score');

                resizeCanvas();
                initBackground();
                
                window.removeEventListener('resize', resizeCanvas);
                window.addEventListener('resize', resizeCanvas);
                
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
                    const currentCanvas = document.getElementById('gameCanvas');
                    if (!currentCanvas) return;
                    
                    if (!gameRunning) window.startGame();
                    else window.flap();
                    e.preventDefault();
                };
            }

            function initBackground() {
                clouds = [];
                for(let i=0; i<5; i++) {
                    clouds.push({
                        x: Math.random() * (canvas?.width || 800),
                        y: Math.random() * 200,
                        speed: 0.2 + Math.random() * 0.5,
                        size: 30 + Math.random() * 50
                    });
                }
            }

            function resizeCanvas() {
                const container = document.getElementById('game-container');
                if (!container || !canvas) return;
                canvas.width = container.clientWidth;
                canvas.height = container.clientHeight;
                initBackground();
            }

            window.startGame = function() {
                if (gameRunning) return;
                
                // Re-init elements if needed
                if (!canvas || !startOverlay) initGame();
                if (!canvas || canvas.height <= 0) resizeCanvas();
                
                // Safety check
                if (!canvas || canvas.height <= 0) {
                   console.error("Canvas not ready");
                   return;
                }

                bird = { x: 80, y: canvas.height/2, velocity: 0, radius: 14, rotation: 0 };
                pipes = [];
                score = 0;
                frame = 0;
                gameRunning = true;
                
                if(startOverlay) startOverlay.style.display = 'none';
                if(gameHud) gameHud.classList.remove('hidden');
                if(scoreDisplay) scoreDisplay.innerText = "0";
                
                gameLoop();
            };

            window.flap = function() {
                if (gameRunning) {
                    bird.velocity = FLAP;
                    bird.rotation = -0.5;
                }
            };

            function gameOver() {
                if (!gameRunning) return;
                gameRunning = false;
                cancelAnimationFrame(animationId);
                
                // Update Overlay UI
                const gameOverContent = document.getElementById('game-over-content');
                const startContent = document.getElementById('start-content');
                const finalScore = document.getElementById('final-score');
                const highscoreBadge = document.getElementById('new-highscore-badge');
                const buttonText = document.getElementById('button-text');
                const startTitle = document.getElementById('start-title');

                if (finalScore) finalScore.innerText = score;
                if (gameOverContent) gameOverContent.classList.remove('hidden');
                if (startContent) startContent.classList.add('hidden');
                if (startTitle) startTitle.innerText = "MAIN LAGI?";
                if (buttonText) buttonText.innerText = "RESTART GAME";

                if (score > userHighScore && score > 0) {
                    if (highscoreBadge) highscoreBadge.classList.remove('hidden');
                    userHighScore = score;
                } else {
                    if (highscoreBadge) highscoreBadge.classList.add('hidden');
                }
                
                if (startOverlay) {
                    startOverlay.style.display = 'flex';
                    startOverlay.classList.remove('opacity-0');
                }
                
                // Submit score to Livewire
                @if(auth()->check())
                    try {
                        @this.submitScore(score);
                    } catch(e) {
                        const lw = window.Livewire.find(document.getElementById('game-container').closest('[wire:id]').getAttribute('wire:id'));
                        if(lw) lw.submitScore(score);
                    }
                @endif
            }

            function drawBird() {
                if (!ctx) return;
                ctx.save();
                ctx.translate(bird.x, bird.y);
                ctx.rotate(bird.rotation);

                // Body
                ctx.fillStyle = '#facc15';
                ctx.beginPath();
                ctx.ellipse(0, 0, bird.radius * 1.2, bird.radius, 0, 0, Math.PI * 2);
                ctx.fill();
                ctx.strokeStyle = '#854d0e';
                ctx.lineWidth = 2;
                ctx.stroke();

                // Wing
                ctx.fillStyle = '#fef08a';
                ctx.beginPath();
                ctx.ellipse(-8, 2, 8, 5, 0.2, 0, Math.PI * 2);
                ctx.fill();
                ctx.stroke();

                // Eye
                ctx.fillStyle = 'white';
                ctx.beginPath();
                ctx.arc(8, -4, 5, 0, Math.PI * 2);
                ctx.fill();
                ctx.fillStyle = 'black';
                ctx.beginPath();
                ctx.arc(10, -4, 2, 0, Math.PI * 2);
                ctx.fill();

                // Beak
                ctx.fillStyle = '#f97316';
                ctx.beginPath();
                ctx.moveTo(14, 0);
                ctx.lineTo(22, 2);
                ctx.lineTo(14, 6);
                ctx.closePath();
                ctx.fill();
                ctx.stroke();

                ctx.restore();
            }

            function drawPipe(x, h, gap) {
                if (!ctx) return;
                const pipeGrad = ctx.createLinearGradient(x, 0, x + PIPE_WIDTH, 0);
                pipeGrad.addColorStop(0, '#1e293b');
                pipeGrad.addColorStop(0.5, '#475569');
                pipeGrad.addColorStop(1, '#1e293b');

                // Top Pipe
                ctx.fillStyle = pipeGrad;
                ctx.fillRect(x, 0, PIPE_WIDTH, h);
                ctx.strokeStyle = '#0f172a';
                ctx.strokeRect(x, 0, PIPE_WIDTH, h);
                
                // Top Cap
                ctx.fillRect(x - 5, h - 20, PIPE_WIDTH + 10, 20);
                ctx.strokeRect(x - 5, h - 20, PIPE_WIDTH + 10, 20);

                // Bottom Pipe
                ctx.fillRect(x, h + gap, PIPE_WIDTH, canvas.height - h - gap);
                ctx.strokeRect(x, h + gap, PIPE_WIDTH, canvas.height - h - gap);

                // Bottom Cap
                ctx.fillRect(x - 5, h + gap, PIPE_WIDTH + 10, 20);
                ctx.strokeRect(x - 5, h + gap, PIPE_WIDTH + 10, 20);
            }

            function gameLoop() {
                if (!gameRunning || !ctx) return;

                // Difficulty Phases
                let currentSpeed = 3;
                let obstacleDifficulty = 0; // 0: None, 1: Slow, 2: Fast
                let currentGap = PIPE_GAP;

                if (score < 10) {
                    currentSpeed = 3.2;
                } else if (score < 30) {
                    currentSpeed = 3.8;
                    obstacleDifficulty = 1;
                } else if (score < 40) {
                    currentSpeed = 2.8;
                    currentGap = 175;
                } else if (score < 60) {
                    currentSpeed = 4.2;
                    obstacleDifficulty = 2;
                    currentGap = 145;
                } else {
                    currentSpeed = 4.8;
                    obstacleDifficulty = 2;
                    currentGap = 135;
                }

                // Background
                const bgGrad = ctx.createLinearGradient(0, 0, 0, canvas.height);
                if (score >= 30 && score < 40) {
                    bgGrad.addColorStop(0, '#064e3b');
                    bgGrad.addColorStop(1, '#065f46');
                } else if (score >= 40) {
                    bgGrad.addColorStop(0, '#1e1b4b');
                    bgGrad.addColorStop(1, '#450a0a');
                } else {
                    bgGrad.addColorStop(0, '#0f172a');
                    bgGrad.addColorStop(1, '#1e293b');
                }
                ctx.fillStyle = bgGrad;
                ctx.fillRect(0, 0, canvas.width, canvas.height);

                // Clouds
                ctx.fillStyle = 'rgba(255, 255, 255, 0.05)';
                clouds.forEach(c => {
                    c.x -= c.speed;
                    if (c.x + c.size < 0) c.x = canvas.width + c.size;
                    ctx.beginPath();
                    ctx.arc(c.x, c.y, c.size, 0, Math.PI * 2);
                    ctx.fill();
                });

                // Bird Physics
                bird.velocity += GRAVITY;
                bird.y += bird.velocity;
                bird.rotation = Math.min(Math.PI / 4, Math.max(-Math.PI / 4, bird.velocity * 0.1));

                if (bird.y + bird.radius > canvas.height || bird.y - bird.radius < 0) {
                    gameOver();
                    return;
                }

                drawBird();

                // Pipes
                const currentSpawnRate = score >= 40 ? 85 : SPAWN_RATE;
                if (frame % currentSpawnRate === 0) {
                    const h = Math.random() * (canvas.height - currentGap - 150) + 75;
                    pipes.push({ 
                        x: canvas.width, 
                        h: h, 
                        gap: currentGap,
                        passed: false,
                        yOffset: 0,
                        direction: Math.random() > 0.5 ? 1 : -1 
                    });
                }

                for (let i = pipes.length - 1; i >= 0; i--) {
                    const p = pipes[i];
                    p.x -= currentSpeed;

                    if (obstacleDifficulty > 0) {
                        const moveSpeed = obstacleDifficulty === 1 ? 1.2 : 2.0;
                        const moveRange = obstacleDifficulty === 1 ? 40 : 75;
                        p.yOffset += p.direction * moveSpeed;
                        if (Math.abs(p.yOffset) > moveRange) p.direction *= -1;
                    }

                    const activeH = p.h + p.yOffset;
                    drawPipe(p.x, activeH, p.gap);

                    if (bird.x + bird.radius - 5 > p.x && bird.x - bird.radius + 5 < p.x + PIPE_WIDTH) {
                        if (bird.y - bird.radius + 5 < activeH || bird.y + bird.radius - 5 > activeH + p.gap) {
                            gameOver();
                            return;
                        }
                    }

                    if (!p.passed && p.x + PIPE_WIDTH < bird.x) {
                        p.passed = true;
                        score++;
                        if (scoreDisplay) scoreDisplay.innerText = score;
                    }

                    if (p.x + PIPE_WIDTH < -20) pipes.splice(i, 1);
                }

                frame++;
                animationId = requestAnimationFrame(gameLoop);
            }

            document.addEventListener('livewire:navigated', initGame);
            document.addEventListener('DOMContentLoaded', initGame);
            initGame();
        })();
    </script>
</div>

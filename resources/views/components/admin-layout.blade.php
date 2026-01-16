<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Admin Panel' }} - {{ \App\Models\SiteSetting::get('site_name', 'ZeonGame') }}</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: { 
                        'brand-yellow': '#FACC15',
                        'brand-dark': '#0F172A',
                        dark: { 900: '#0F172A', 800: '#1E293B', 700: '#334155' } 
                    }
                }
            }
        }
    </script>
    @livewireStyles
</head>
<body class="antialiased text-gray-100 bg-dark-900 font-sans">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="z-30 flex-shrink-0 hidden w-64 overflow-y-auto border-r border-gray-700 bg-dark-800 lg:block">
            <div class="py-6">
                <!-- Logo/Header -->
                <div class="px-6 mb-8">
                    <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Main Menu</h2>
                </div>

                <!-- Nav Items -->
                <nav class="space-y-1">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-6 py-3 text-gray-400 transition-all hover:text-brand-yellow hover:bg-white/5 border-l-4 border-transparent {{ request()->routeIs('admin.dashboard') ? 'bg-white/5 border-brand-yellow text-white' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Dashboard
                    </a>
                    
                    <a href="{{ route('admin.games.index') }}" class="flex items-center gap-3 px-6 py-3 text-gray-400 transition-all hover:text-brand-yellow hover:bg-white/5 border-l-4 border-transparent {{ request()->routeIs('admin.games*') && !request()->routeIs('admin.vouchers*') ? 'bg-white/5 border-brand-yellow text-white' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Games
                    </a>
                    
                    <a href="{{ route('admin.vouchers') }}" class="flex items-center gap-3 px-6 py-3 text-gray-400 transition-all hover:text-brand-yellow hover:bg-white/5 border-l-4 border-transparent {{ request()->routeIs('admin.vouchers*') ? 'bg-white/5 border-brand-yellow text-white' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                        </svg>
                        Vouchers
                    </a>

                    <a href="{{ route('admin.flash-sales.index') }}" class="flex items-center gap-3 px-6 py-3 text-gray-400 transition-all hover:text-brand-yellow hover:bg-white/5 border-l-4 border-transparent {{ request()->routeIs('admin.flash-sales*') ? 'bg-white/5 border-brand-yellow text-white' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        Flash Sales
                    </a>
                    
                    <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-6 py-3 text-gray-400 transition-all hover:text-brand-yellow hover:bg-white/5 border-l-4 border-transparent {{ request()->routeIs('admin.products*') ? 'bg-white/5 border-brand-yellow text-white' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        Products
                    </a>
                    
                    <a href="{{ route('admin.orders') }}" class="flex items-center gap-3 px-6 py-3 text-gray-400 transition-all hover:text-brand-yellow hover:bg-white/5 border-l-4 border-transparent {{ request()->routeIs('admin.orders') ? 'bg-white/5 border-brand-yellow text-white' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Orders
                    </a>
                    
                    <a href="{{ route('admin.users') }}" class="flex items-center gap-3 px-6 py-3 text-gray-400 transition-all hover:text-brand-yellow hover:bg-white/5 border-l-4 border-transparent {{ request()->routeIs('admin.users') ? 'bg-white/5 border-brand-yellow text-white' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        Users
                    </a>
                    
                    <a href="{{ route('admin.payment-methods') }}" class="flex items-center gap-3 px-6 py-3 text-gray-400 transition-all hover:text-brand-yellow hover:bg-white/5 border-l-4 border-transparent {{ request()->routeIs('admin.payment-methods') ? 'bg-white/5 border-brand-yellow text-white' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        Payment Methods
                    </a>
                    <a href="{{ route('admin.banners') }}" class="flex items-center gap-3 px-6 py-3 text-gray-400 transition-all hover:text-brand-yellow hover:bg-white/5 border-l-4 border-transparent {{ request()->routeIs('admin.banners') ? 'bg-white/5 border-brand-yellow text-white' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Banners
                    </a>

                    <a href="{{ route('admin.reviews') }}" class="flex items-center gap-3 px-6 py-3 text-gray-400 transition-all hover:text-brand-yellow hover:bg-white/5 border-l-4 border-transparent {{ request()->routeIs('admin.reviews') ? 'bg-white/5 border-brand-yellow text-white' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        Reviews
                    </a>

                    <a href="{{ route('admin.referrals') }}" class="flex items-center gap-3 px-6 py-3 text-gray-400 transition-all hover:text-brand-yellow hover:bg-white/5 border-l-4 border-transparent {{ request()->routeIs('admin.referrals') ? 'bg-white/5 border-brand-yellow text-white' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        Referrals
                    </a>

                    <a href="{{ route('admin.news') }}" class="flex items-center gap-3 px-6 py-3 text-gray-400 transition-all hover:text-brand-yellow hover:bg-white/5 border-l-4 border-transparent {{ request()->routeIs('admin.news') ? 'bg-white/5 border-brand-yellow text-white' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20l-7-7 7-7M5 12h14"/>
                        </svg>
                        Berita & Promo
                    </a>

                    <a href="{{ route('admin.settings') }}" class="flex items-center gap-3 px-6 py-3 text-gray-400 transition-all hover:text-brand-yellow hover:bg-white/5 border-l-4 border-transparent {{ request()->routeIs('admin.settings') ? 'bg-white/5 border-brand-yellow text-white' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Site Settings
                    </a>

                    <a href="{{ route('admin.provider.catalog') }}" class="flex items-center gap-3 px-6 py-3 text-gray-400 transition-all hover:text-brand-yellow hover:bg-white/5 border-l-4 border-transparent {{ request()->routeIs('admin.provider.catalog') ? 'bg-white/5 border-brand-yellow text-white' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Katalog Provider
                    </a>

                    <a href="{{ route('admin.api') }}" class="flex items-center gap-3 px-6 py-3 text-gray-400 transition-all hover:text-brand-yellow hover:bg-white/5 border-l-4 border-transparent {{ request()->routeIs('admin.api') ? 'bg-white/5 border-brand-yellow text-white' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 011-1h1a2 2 0 100-4H7a1 1 0 01-1-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"/>
                        </svg>
                        API Integration
                    </a>
                    
                    <a href="{{ url('/') }}" class="flex items-center gap-3 px-6 py-3 text-gray-400 transition-all hover:text-white hover:bg-white/5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali ke Website
                    </a>
                    
                    <form method="POST" action="{{ route('logout') }}" class="px-6 mt-6">
                        @csrf
                        <button type="submit" class="flex items-center w-full gap-3 px-4 py-3 text-sm font-semibold text-black transition-all bg-brand-yellow rounded-xl hover:bg-yellow-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Logout
                        </button>
                    </form>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex flex-col flex-1 w-full overflow-hidden">
            <!-- Top bar -->
            <header class="z-10 py-4 border-b border-gray-700 bg-dark-800/50 backdrop-blur-sm">
                <div class="flex items-center justify-between px-6">
                    <div>
                        <h1 class="text-xl font-bold text-white">{{ \App\Models\SiteSetting::get('site_name', 'ZeonGame') }} Admin</h1>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="text-right">
                            <div class="text-sm font-bold text-white">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-brand-yellow">Administrator</div>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-brand-yellow flex items-center justify-center text-black font-bold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-dark-900">
                <div class="px-6 py-8 mx-auto max-w-7xl">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:init', () => {
            console.log('✅ Livewire Initialized in Admin Layout');
            
            if (typeof Swal === 'undefined') {
                console.error('❌ SweetAlert2 is NOT loaded');
                alert('CRITICAL ERROR: SweetAlert2 is not loaded. Please check your internet connection or ad blocker.');
            } else {
                console.log('✅ SweetAlert2 is loaded');
            }

            // Event listeners removed - using inline AlpineJS logic for robustness
            // GENERIC ACTION CONFIRMATION (DELETE, TOGGLE, ETC)
            Livewire.on('confirm-action', (data) => {
                const payload = Array.isArray(data) ? data[0] : data;
                Swal.fire({
                    title: payload.title || 'Konfirmasi Tindakan',
                    text: payload.text || 'Apakah Anda yakin ingin melakukan ini?',
                    icon: payload.icon || 'question',
                    background: '#1E293B',
                    color: '#fff',
                    showCancelButton: true,
                    confirmButtonColor: payload.confirmButtonColor || '#3B82F6',
                    cancelButtonColor: '#64748B',
                    confirmButtonText: payload.confirmText || 'Ya, Lanjutkan'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch(payload.event, payload.params);
                    }
                });
            });
        });
    </script>
    <livewire:notification-toast />
    @livewireScripts

</body>
</html>

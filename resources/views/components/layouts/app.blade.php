<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? \App\Models\SiteSetting::get('site_name', config('app.name')) }}</title>
    <meta name="description" content="{{ \App\Models\SiteSetting::get('site_description') }}">
    <meta name="keywords" content="{{ \App\Models\SiteSetting::get('meta_keywords') }}">
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#FACC15">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        'brand-yellow': '#FACC15', // Yellow-400
                        'brand-dark': '#0F172A',   // Slate-900
                        'dark': {
                            900: '#0F172A',
                            800: '#1E293B',
                            700: '#334155'
                        }
                    }
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @livewireStyles
</head>
<body class="font-sans antialiased text-white bg-slate-900">
    <!-- Navbar -->
    <nav class="sticky top-0 z-50 border-b border-white/10 bg-slate-900/90 backdrop-blur-md">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Top Bar (Logo, Search, Actions) -->
            <div class="flex items-center justify-between h-20 gap-8">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="/" class="flex items-center gap-2">
                        @if($logo = \App\Models\SiteSetting::get('site_logo'))
                            <img src="{{ Storage::url($logo) }}" alt="{{ \App\Models\SiteSetting::get('site_name') }}" class="h-10 w-auto">
                        @else
                            <span class="text-3xl font-black italic text-brand-yellow">Z</span>
                            <span class="text-xl font-bold text-white">{{ \App\Models\SiteSetting::get('site_name', 'ZeonGame') }}</span>
                        @endif
                    </a>
                </div>

                <!-- Desktop Search Bar -->
                <div class="flex-1 hidden max-w-2xl md:block">
                    <livewire:game-search />
                </div>

                <!-- Right Actions -->
                <div class="hidden md:flex items-center gap-4">
                    <!-- Language Switcher -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center gap-2 px-3 py-1.5 bg-slate-800 rounded-full border border-gray-700 hover:border-brand-yellow/50 transition-all">
                            @if(app()->getLocale() == 'id')
                                <img src="https://flagcdn.com/w20/id.png" class="w-4 h-4 rounded-full" alt="ID">
                                <span class="text-xs font-bold">ID</span>
                            @else
                                <img src="https://flagcdn.com/w20/us.png" class="w-4 h-4 rounded-full" alt="EN">
                                <span class="text-xs font-bold">EN</span>
                            @endif
                            <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-32 bg-dark-800 border border-gray-700 rounded-xl shadow-xl py-1 z-[60]" style="display: none;">
                            <a href="{{ route('locale.switch', 'id') }}" class="flex items-center gap-2 px-4 py-2 text-xs text-gray-300 hover:bg-dark-700 hover:text-white transition-all">
                                <img src="https://flagcdn.com/w20/id.png" class="w-4 h-4 rounded-full"> Indonesia
                            </a>
                            <a href="{{ route('locale.switch', 'en') }}" class="flex items-center gap-2 px-4 py-2 text-xs text-gray-300 hover:bg-dark-700 hover:text-white transition-all">
                                <img src="https://flagcdn.com/w20/us.png" class="w-4 h-4 rounded-full"> English
                            </a>
                        </div>
                    </div>
                    @auth
                        <livewire:member.notification-center />
                        <!-- User Dropdown -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center gap-2 text-sm font-bold text-white hover:text-brand-yellow focus:outline-none bg-dark-800 pl-2 pr-4 py-1.5 rounded-full border border-gray-700/50 hover:border-brand-yellow/50 transition-all">
                                <img src="{{ Auth::user()->avatar_url }}" class="w-8 h-8 rounded-full object-cover border border-gray-600">
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open" @click.away="open = false" 
                                 class="absolute right-0 mt-2 w-56 bg-dark-800 border border-gray-700 rounded-xl shadow-xl py-2 z-50"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 style="display: none;">
                                 
                                <div class="px-4 py-3 border-b border-gray-700/50 mb-2">
                                    <p class="text-xs text-gray-500">{{ __('Signed in as') }}</p>
                                    <p class="text-sm font-bold text-white truncate">{{ Auth::user()->email }}</p>
                                </div>

                                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-300 hover:bg-dark-700 hover:text-white hover:border-l-4 hover:border-brand-yellow transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                                    {{ __('Dashboard') }}
                                </a>
                                
                                <a href="{{ route('favorites') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-300 hover:bg-dark-700 hover:text-white hover:border-l-4 hover:border-brand-yellow transition-all">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/>
                                    </svg>
                                    {{ __('My Favorites') }}
                                </a>
                                
                                 <a href="{{ route('profile') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-300 hover:bg-dark-700 hover:text-white hover:border-l-4 hover:border-brand-yellow transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    {{ __('Account Settings') }}
                                </a>

                                <a href="{{ route('referral') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-300 hover:bg-dark-700 hover:text-white hover:border-l-4 hover:border-brand-yellow transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                    Program Referral
                                </a>

                                <a href="{{ route('loyalty') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-300 hover:bg-dark-700 hover:text-white hover:border-l-4 hover:border-brand-yellow transition-all">
                                    <svg class="w-4 h-4 text-indigo-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    {{ __('My Points') }}
                                </a>
                                
                                <div class="border-t border-gray-700/50 mt-2 mb-2"></div>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left flex items-center gap-2 px-4 py-2 text-sm text-red-400 hover:bg-dark-700 hover:text-red-300 hover:border-l-4 hover:border-red-500 transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                                        {{ __('Logout') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="flex items-center gap-2 text-sm font-bold text-white hover:text-brand-yellow">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="flex items-center gap-2 text-sm font-bold text-white hover:text-brand-yellow">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                            Daftar
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Bottom Menu -->
            <div class="flex items-center gap-6 overflow-x-auto pb-4 md:pb-0 text-sm font-medium no-scrollbar">
                <a href="/" class="flex items-center gap-2 pb-2 md:pb-4 border-b-2 transition-colors {{ request()->is('/') ? 'text-brand-yellow border-brand-yellow' : 'text-gray-300 border-transparent hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    {{ __('Home') }}
                </a>
                <a href="{{ route('transaction.search') }}" class="flex items-center gap-2 pb-2 md:pb-4 border-b-2 transition-colors {{ request()->routeIs('transaction.search') ? 'text-brand-yellow border-brand-yellow' : 'text-gray-300 border-transparent hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    {{ __('Track Order') }}
                </a>
                <a href="{{ route('calculator.index') }}" class="flex items-center gap-2 pb-2 md:pb-4 border-b-2 transition-colors {{ request()->is('calculator*') ? 'text-brand-yellow border-brand-yellow' : 'text-gray-300 border-transparent hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    {{ __('Calculator') }}
                </a>
                <a href="{{ route('leaderboard') }}" class="flex items-center gap-2 pb-2 md:pb-4 border-b-2 transition-colors {{ request()->routeIs('leaderboard') ? 'text-brand-yellow border-brand-yellow' : 'text-gray-300 border-transparent hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    {{ __('Leaderboard') }}
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="min-h-screen">
        <!-- Global Alerts -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 space-y-4">
            @if(session()->has('success'))
                <div x-data="{ show: true }" x-show="show" class="p-4 bg-green-500/10 border border-green-500/20 rounded-2xl text-green-500 text-sm flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button @click="show = false" class="text-green-500/50 hover:text-green-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            @endif

            @if(session()->has('warning'))
                <div x-data="{ show: true }" x-show="show" class="p-4 bg-yellow-500/10 border border-yellow-500/20 rounded-2xl text-yellow-500 text-sm flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <span>{{ session('warning') }}</span>
                    </div>
                    <button @click="show = false" class="text-yellow-500/50 hover:text-yellow-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            @endif

            @if(session()->has('error'))
                <div x-data="{ show: true }" x-show="show" class="p-4 bg-red-500/10 border border-red-500/20 rounded-2xl text-red-500 text-sm flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button @click="show = false" class="text-red-500/50 hover:text-red-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            @endif
        </div>

        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="pt-16 pb-8 bg-black border-t border-white/10">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 gap-8 md:grid-cols-4 lg:grid-cols-5">
                <div class="col-span-2 lg:col-span-2">
                    <h3 class="mb-4 text-xl font-bold text-brand-yellow">Peta Situs</h3>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="/" class="hover:text-white">Beranda</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-white">Masuk</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-white">Daftar</a></li>
                        <li><a href="{{ route('transaction.search') }}" class="hover:text-white">Cek Transaksi</a></li>
                        <li><a href="#" class="hover:text-white">Hubungi Kami</a></li>
                        <li><a href="#" class="hover:text-white">Ulasan</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="mb-4 text-xl font-bold text-brand-yellow">Dukungan</h3>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-white">WhatsApp</a></li>
                        <li><a href="#" class="hover:text-white">Email</a></li>
                        <li><a href="#" class="hover:text-white">Instagram</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="mb-4 text-xl font-bold text-brand-yellow">Legalitas</h3>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-white">Kebijakan Pribadi</a></li>
                        <li><a href="#" class="hover:text-white">Syarat & Ketentuan</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="mb-4 text-xl font-bold text-brand-yellow">Social Media</h3>
                    <ul class="space-y-2 text-sm text-gray-400">
                        @if($link = \App\Models\SiteSetting::get('tiktok_url'))
                            <li><a href="{{ $link }}" target="_blank" class="hover:text-white">Tiktok {{ \App\Models\SiteSetting::get('site_name', 'ZeonGame') }}</a></li>
                        @endif
                        @if($link = \App\Models\SiteSetting::get('instagram_url'))
                            <li><a href="{{ $link }}" target="_blank" class="hover:text-white">Instagram {{ \App\Models\SiteSetting::get('site_name', 'ZeonGame') }}</a></li>
                        @endif
                        @if($link = \App\Models\SiteSetting::get('youtube_url'))
                            <li><a href="{{ $link }}" target="_blank" class="hover:text-white">Youtube {{ \App\Models\SiteSetting::get('site_name', 'ZeonGame') }}</a></li>
                        @endif
                    </ul>
                </div>
            </div>

            <div class="pt-8 mt-12 border-t border-white/10 flex justify-between items-center">
                <p class="text-sm text-gray-500">
                    {{ \App\Models\SiteSetting::get('footer_text', '&copy; ' . date('Y') . ' ' . \App\Models\SiteSetting::get('site_name', 'ZeonGame') . '. All rights reserved.') }}
                </p>
                @if($wa = \App\Models\SiteSetting::get('whatsapp_number'))
                    <a href="https://wa.me/{{ $wa }}?text=Halo%20{{ urlencode(\App\Models\SiteSetting::get('site_name', 'ZeonGame')) }}%2C%20saya%20ingin%20bertanya%20mengenai%20pesanan%20saya." 
                       target="_blank"
                       class="bg-brand-yellow text-black px-4 py-2 rounded-lg font-bold text-sm flex items-center gap-2 hover:bg-yellow-400 transition-all shadow-lg shadow-yellow-500/20">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.937 3.659 1.432 5.632 1.433h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        WHATSAPP CS
                    </a>
                @else
                    <button class="bg-brand-yellow text-black px-4 py-2 rounded-lg font-bold text-sm flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        CUSTOMER SERVICE
                    </button>
                @endif
            </div>
        </div>
    </footer>

    @livewireScripts
    <!-- AOS Animation Script -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
        });
    </script>
    
    <!-- Tawk.to Live Chat Widget -->
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/67598e4daf5bfec1dbdbf52c/1ies6p3a5';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
    </script>
    <!--End of Tawk.to Script-->
    
    <!-- PWA Registration -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js');
            });
        }
    </script>
    
    @stack('scripts')

</body>
</html>

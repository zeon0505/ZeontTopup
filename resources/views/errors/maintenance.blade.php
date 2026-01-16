<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance - {{ \App\Models\SiteSetting::get('site_name', 'ZeonGame') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#0f172a] text-white flex items-center justify-center min-h-screen p-6">
    <div class="max-w-md w-full text-center space-y-8">
        <!-- Brand -->
        <div class="flex flex-col items-center gap-4">
            @if($logo = \App\Models\SiteSetting::get('site_logo'))
                <img src="{{ \Illuminate\Support\Facades\Storage::url($logo) }}" class="h-16 w-auto" alt="Logo">
            @else
                <span class="text-3xl font-black italic uppercase tracking-tighter text-brand-yellow">
                    ZEON<span class="text-white">GAME</span>
                </span>
            @endif
        </div>

        <!-- Maintenance Icon -->
        <div class="relative">
            <div class="w-24 h-24 bg-brand-yellow/10 rounded-3xl flex items-center justify-center mx-auto animate-pulse">
                <svg class="w-12 h-12 text-brand-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 011-1h1a2 2 0 100-4H7a1 1 0 01-1-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"/>
                </svg>
            </div>
        </div>

        <!-- Content -->
        <div class="space-y-4">
            <h1 class="text-4xl font-black italic uppercase tracking-wider">Sedang Perawatan</h1>
            <p class="text-gray-400 text-lg leading-relaxed">
                Kami sedang melakukan pembaruan untuk meningkatkan pengalaman Anda. Silakan kembali lagi beberapa saat lagi.
            </p>
        </div>

        <!-- Social Links -->
        <div class="flex items-center justify-center gap-6 pt-8">
            <div class="flex items-center gap-2 text-gray-500 text-sm font-bold uppercase tracking-widest">
                Follow Us:
            </div>
            @if($ig = \App\Models\SiteSetting::get('instagram_url'))
                <a href="{{ $ig }}" class="text-gray-400 hover:text-brand-yellow transition-colors cursor-pointer">Instagram</a>
            @endif
            @if($wa = \App\Models\SiteSetting::get('whatsapp_number'))
                <a href="https://wa.me/{{ $wa }}" class="text-gray-400 hover:text-brand-yellow transition-colors cursor-pointer">WhatsApp</a>
            @endif
        </div>

        <div class="pt-12">
            <p class="text-xs text-gray-600 font-medium">
                {{ \App\Models\SiteSetting::get('footer_text', '&copy; ' . date('Y') . ' ZeonGame. All rights reserved.') }}
            </p>
        </div>
    </div>
</body>
</html>

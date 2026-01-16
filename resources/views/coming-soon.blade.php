<x-layouts.app>
    <div class="min-h-screen bg-dark-900 flex items-center justify-center p-4">
        <div class="text-center" data-aos="zoom-in">
            <!-- Icon/Illustration -->
            <div class="relative w-32 h-32 mx-auto mb-8">
                <div class="absolute inset-0 bg-brand-yellow blur-xl opacity-20 animate-pulse"></div>
                <div class="relative w-full h-full bg-dark-800 rounded-full flex items-center justify-center border-2 border-brand-yellow/30 shadow-[0_0_30px_rgba(250,204,21,0.2)]">
                    <svg class="w-16 h-16 text-brand-yellow animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                </div>
            </div>

            <!-- Text -->
            <h1 class="text-4xl md:text-6xl font-black text-white italic mb-4">
                COMING <span class="text-brand-yellow">SOON</span>
            </h1>
            <p class="text-gray-400 text-lg md:text-xl max-w-lg mx-auto mb-10">
                Fitur ini sedang dalam tahap pengembangan oleh tim ZeonGame.
                Nantikan fitur menarik ini segera! 🚀
            </p>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ url('/') }}" class="inline-flex items-center justify-center px-8 py-3 bg-brand-yellow text-black font-bold rounded-xl hover:bg-yellow-400 transition-all hover:scale-105 shadow-[0_0_20px_rgba(250,204,21,0.3)]">
                    Kembali ke Home
                </a>
                <a href="https://wa.me/6281234567890" class="inline-flex items-center justify-center px-8 py-3 bg-dark-800 border border-gray-700 text-white font-bold rounded-xl hover:bg-dark-700 transition-all hover:scale-105">
                    Hubungi Admin
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>

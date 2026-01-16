AE<x-layouts.app>
    <div class="py-12 bg-dark-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Welcome Banner -->
            <div class="bg-gradient-to-r from-brand-yellow/10 to-transparent border border-brand-yellow/20 rounded-2xl p-6 md:p-8 flex items-center justify-between">
                <div class="flex items-center gap-6">
                    <img src="{{ Auth::user()->avatar_url }}" class="w-20 h-20 rounded-full object-cover border-4 border-dark-900 shadow-lg hidden md:block">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-black text-white italic">WELCOME BACK, {{ Auth::user()->name }}! 🚀</h1>
                        <p class="text-gray-400 mt-2">Siap untuk top up game favoritmu lagi?</p>
                    </div>
                </div>
                <!-- Saldo Card -->
                <div class="bg-dark-800 p-4 rounded-xl border border-gray-700 hover:border-brand-yellow transition-colors flex items-center gap-4">

                    <div>
                        <div class="text-gray-400 text-xs uppercase font-bold tracking-wider">Saldo Akun</div>
                        <div class="text-white font-black text-xl">Rp {{ number_format(Auth::user()->balance ?? 0, 0, ',', '.') }}</div>
                    </div>
                    <a href="{{ route('deposit') }}" class="ml-4 bg-brand-yellow text-black px-4 py-2 rounded-lg font-bold text-sm hover:bg-yellow-400 transition-colors shadow-lg shadow-brand-yellow/20">
                        Top Up +
                    </a>
                </div>
            </div>

            <!-- Balance Status / Pending Sync -->
            <livewire:member.balance-status />

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-1 space-y-8">
                    <livewire:member.level-badge />
                    <livewire:member.daily-check-in />
                    <livewire:member.user-badge />
                </div>
                <div class="lg:col-span-2">
                    <livewire:member.loyalty-points />
                </div>
            </div>

            <!-- Spend Analytics Component -->
            <livewire:member.spend-analytics />

            <!-- Transaction History Component -->
            <livewire:member.transaction-history />

        </div>
    </div>
</x-layouts.app>

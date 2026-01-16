<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-brand-yellow border border-transparent rounded-xl font-bold text-xs text-black uppercase tracking-widest hover:bg-yellow-400 focus:bg-yellow-400 active:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-brand-yellow focus:ring-offset-2 focus:ring-offset-dark-900 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>

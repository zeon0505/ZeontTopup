<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-dark-800 border border-gray-600 rounded-xl font-semibold text-xs text-gray-200 uppercase tracking-widest shadow-sm hover:bg-dark-700 focus:outline-none focus:ring-2 focus:ring-brand-yellow focus:ring-offset-2 focus:ring-offset-dark-900 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>

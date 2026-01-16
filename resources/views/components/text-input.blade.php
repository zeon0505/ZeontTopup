@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-dark-900 border-gray-700 text-white focus:border-brand-yellow focus:ring-brand-yellow rounded-xl shadow-sm placeholder-gray-500']) }}>

import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'brand-yellow': '#FACC15', // Bright yellow
                'brand-dark': '#0F172A',   // Deep dark blue/slate
                'brand-darker': '#020617', // Almost black
                'dark': {
                    900: '#0F172A',
                    800: '#1E293B',
                    700: '#334155',
                },
            },
        },
    },

    plugins: [forms],
};

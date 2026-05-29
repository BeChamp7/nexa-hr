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
                sans: ['Figtree', 'Inter', ...defaultTheme.fontFamily.sans],
                urdu: ['"Noto Nastaliq Urdu"', '"Noto Naskh Arabic"', 'serif'],
            },
            colors: {
                brand: {
                    50: '#eef4ff',
                    100: '#dae6ff',
                    200: '#bdd2ff',
                    300: '#90b4ff',
                    400: '#5b8bff',
                    500: '#3563ff',
                    600: '#1e40f5',
                    700: '#172fe1',
                    800: '#1929b6',
                    900: '#1b298f',
                    950: '#151a57',
                },
            },
            boxShadow: {
                card: '0 1px 2px 0 rgb(16 24 40 / 0.04), 0 1px 3px 0 rgb(16 24 40 / 0.06)',
                'card-md': '0 4px 8px -2px rgb(16 24 40 / 0.08), 0 2px 4px -2px rgb(16 24 40 / 0.04)',
            },
        },
    },

    plugins: [forms],
};

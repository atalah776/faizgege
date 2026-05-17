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
            colors: {
                primary: {
                    DEFAULT: '#0d5c4a',
                    dark: '#094839',
                    light: '#e6f2ef',
                    mid: '#1a7a62',
                },
                accent: {
                    DEFAULT: '#20c997',
                    soft: '#b2f0e0',
                },
                bg: '#f8fafa',
            },
            fontFamily: {
                sans: ['"Poppins"', ...defaultTheme.fontFamily.sans],
                serif: ['"Lora"', ...defaultTheme.fontFamily.serif],
            },
        },
    },

    plugins: [forms],
};
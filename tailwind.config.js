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
                sans: ['Work Sans', 'sans-serif'],
            },

            colors: {
                noir: '#141414',
                noirlight: '#2A2A2A',
                grisclair: '#F7F7F7',
                jaune: '#FFCA2B',
            }
        },
    },

    plugins: [forms],
};

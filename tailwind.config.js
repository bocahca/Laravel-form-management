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
                primary: '#1F4E79',
                accent:  '#F4A01E',
                sidebar: '#F4F6F8',
                'gray-light': '#F4F6F8',
            },

        },
    },

    plugins: [forms],
};

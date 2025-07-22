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
                    DEFAULT: '#1E40AF',
                    light: '#3B82F6',
                    dark: '#1E3A8A',
                },
                secondary: {
                    DEFAULT: '#F59E0B',
                    light: '#FBBF24',
                    dark: '#B45309',
                },
                accent: '#10B981',
            },
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                heading: ['Poppins', ...defaultTheme.fontFamily.sans],
            },

        },
    },

    plugins: [forms],
};

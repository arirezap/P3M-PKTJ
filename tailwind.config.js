import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Poppins', 'sans-serif'],
            },
            colors: {
                kemenhub: {
                    deep: '#0B2A59',
                    dark: '#081D3C',
                    mid: '#1E40AF',
                    gold: '#EAB308',
                    amber: '#CA8A04',
                },
            },
        },
    },
    plugins: [forms],
};

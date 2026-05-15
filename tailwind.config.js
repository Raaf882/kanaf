import defaultTheme from 'tailwindcss/defaultTheme';

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
                kanaf: {
                    green:       '#1A6B3C',
                    'green-mid': '#2E8B57',
                    'green-light': '#F0FAF4',
                    purple:      '#6B21A8',
                    'purple-light': '#F5F0FF',
                    gold:        '#B8860B',
                },
            },
            fontFamily: {
                cairo: ['Cairo', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    plugins: [],
};

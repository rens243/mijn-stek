// const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    theme: {
        // fontFamily: {
        //     sans: ['Nunito', ...defaultTheme.fontFamily.sans],
        // },
        extend: {
            cursor: {
                auto: 'auto',
                default: 'default',
                pointer: 'pointer',
                wait: 'wait',
                text: 'text',
                move: 'move',
                'not-allowed': 'not-allowed',
                grab: 'grab',
                grabbing: 'grabbing'
            },
        },
    },
    variants: {
        extend: {
            backgroundColor: ['active'],
            opacity: ['disabled'],
        },
    },
    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
    purge: {
        content: [
            './resources/**/*.blade.php',
            './resources/**/*.html',
            './resources/**/*.js',
            './resources/**/*.svelte',
            './resources/**/*.vue',

            './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
            './vendor/laravel/jetstream/**/*.blade.php',
            './storage/framework/views/*.php',
            './resources/views/**/*.blade.php',
        ],
        options: {
            safelist: ['/svelte-/', 'cursor-grabbing', 'cursor-grab'],
        },
    },
};

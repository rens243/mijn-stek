module.exports = {
    darkMode: false, // or 'media' or 'class'
    theme: {
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
            }
        },
    },
    variants: {
        extend: {
            backgroundColor: ['active']
        },
    },
    plugins: [],
    purge: {
        content: [
            './resources/**/*.blade.php',
            './resources/**/*.html',
            './resources/**/*.js',
            './resources/**/*.svelte',
            './resources/**/*.vue',
        ],
        options: {
            safelist: ['/svelte-/', 'cursor-grabbing', 'cursor-grab'],
        },
    },
}

module.exports = {
  purge: [],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {},
  },
  variants: {
    extend: {},
  },
  plugins: [],
}


module.exports = {
    purge: {
        enabled: process.env.NODE_ENV === 'production',
        mode: 'all',
        content: ['./**/**/*.html', './**/**/*.svelte'],
        options: {
            whitelistPatterns: [/svelte-/],
            defaultExtractor: (content) =>
                [...content.matchAll(/(?:class:)*([\w\d-/:%.]+)/gm)].map(([_match, group, ..._rest]) => group),
        },
    },
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
}

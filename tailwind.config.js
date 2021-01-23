const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');

module.exports = {
    purge: ['./storage/framework/views/*.php', './resources/views/**/*.blade.php'],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            backgroundColor: {
                page: 'var(--page-background-color)',
                card: 'var(--card-background-color)',
                button: 'var(--button-background-color)',
                header: 'var(--header-background-color)',
            },
            colors: {
                default: 'var(--text-default-color)',
                accent: 'var(--text-accent-color)',
                'accent-light': 'var(--text-accent-light-color)',
                muted: 'var(--text-muted-color)',
                'muted-light': 'var(--text-muted-light-color)',
                'error': 'var(--text-error-color)',
            }
        },

    },

    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },

    plugins: [require('@tailwindcss/forms')],
};

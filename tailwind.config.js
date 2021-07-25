const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');

module.exports = {
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                'grey-background': '#f7f8fc',
                transparent: 'transparent',
                current: 'currentColor',
          
                black: colors.black,
                white: colors.white,
                gray: colors.trueGray,
                'blue': '#328af1',
                'blue-hover': '#2879bd',
                'yellow' : '#ffc73c',
                'red' : '#ec454f',
                'green' : '#1aab8b',
                'purple' : '#8b60ed',
            },
            maxWidth:{
                custom: '62.5rem',
            },
            spacing: {
                70: '17.5rem',
                175: '43.75rem',
            },
            fontFamily: {
                sans: ['Open sans', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },

    plugins: [require('@tailwindcss/forms')],
};

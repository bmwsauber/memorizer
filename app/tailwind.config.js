const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './Resources/**/*.blade.php',
        './Resources/assets/**/*.js',
        './Resources/assets/components/*.vue',
    ],
    darkMode: false, // or 'media' or 'class'
    theme: {
        extend: {
            colors: {
                teal: {
                    100: '#17a2b8',
                    200: '#117a8b',
                },
                crimson: {
                    100: '#dc3545',
                    200: '#bd2130',
                },
                new: '#28a745',
                normal: '#aaaaaa',
                magic: '#8383f7',
                rare: '#f8b335',
                unique: '#ba661d',
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

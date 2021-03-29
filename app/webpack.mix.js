const dotenvExpand = require('dotenv-expand');
dotenvExpand(require('dotenv').config({ path: './.env'/*, debug: true*/}));

const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

const tailwindcss = require('tailwindcss');

mix.setPublicPath('./public').mergeManifest();

mix.js(__dirname + '/Modules/Layout/Resources/assets/js/memocards.js', 'js/app.js')
    .sass(__dirname + '/Modules/Layout/Resources/assets/sass/memocards.scss', 'css/app.css')
    .options({
        processCssUrls: false,
        postCss: [
            tailwindcss('./tailwind.config.js'),
            //require('postcss-import'),
            //require('tailwindcss'),
            //require('autoprefixer'),
        ],
    });

if (mix.inProduction()) {
    mix.version();
}

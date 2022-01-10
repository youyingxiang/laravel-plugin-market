const dotenvExpand = require('dotenv-expand');
const tailwindcss = require('tailwindcss');
dotenvExpand(require('dotenv').config({ path: '../../.env'/*, debug: true*/}));

const mix = require('laravel-mix');

mix.setPublicPath('Resources/assets/build')

mix.vue({ version: 3 })
    .js(__dirname + '/Resources/assets/js/app.js', 'js/app.js')
    .sass( __dirname + '/Resources/assets/sass/app.scss','css/app.css')
    .options({
        processCssUrls: false,
        postCss: [ tailwindcss('./tailwind.config.js') ],
    })

mix.copy("Resources/assets/build",  "../../public/plugins/pluginmarket/build")


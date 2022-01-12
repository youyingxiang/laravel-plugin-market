const tailwindcss = require('tailwindcss');

const mix = require('laravel-mix');

mix.setPublicPath('resources/build')

mix.vue({ version: 3 })
    .js(__dirname + '/resources/assets/js/app.js', 'js/app.js')
    .sass( __dirname + '/resources/assets/sass/app.scss','css/app.css')
    .options({
        processCssUrls: false,
        postCss: [ tailwindcss('./tailwind.config.js') ],
    })
// if (mix.inProduction()) {
//     mix.version()
// }
mix.copyDirectory('resources/build', '../public/vendor/pluginmarket')



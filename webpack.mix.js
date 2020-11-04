let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
mix.setPublicPath('assets');
mix.js('resources/assets/js/app.js', 'assets/js')
   .sass('resources/assets/sass/app.scss', 'assets/css')
   .version()
   .options({
        processCssUrls: false
    })
    .copyDirectory('node_modules/@fortawesome/fontawesome-free/webfonts', 'assets/webfonts')
    .copyDirectory('node_modules/summernote/dist/font', 'assets/css/font')

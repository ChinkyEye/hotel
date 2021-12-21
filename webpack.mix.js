const mix = require('laravel-mix');

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

mix.js('resources/js/app.js', 'public/js/app.js')
    .sass('resources/sass/app.scss', 'public/css');
mix.js('resources/js/managerapp.js', 'public/js/managerapp.js');
mix.js('resources/js/counterapp.js', 'public/js/counterapp.js');
mix.js('resources/js/barapp.js', 'public/js/barapp.js');
mix.js('resources/js/kitchenapp.js', 'public/js/kitchenapp.js');

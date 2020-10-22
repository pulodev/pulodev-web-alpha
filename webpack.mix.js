const mix = require('laravel-mix');
require('laravel-mix-workbox');
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */
mix.copyDirectory('resources/img', 'public/img');
mix.copy('resources/manifest.webmanifest', 'public/manifest.webmanifest');
mix.js('resources/js/timeline.js','public/js');

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/css/app.sass', 'public/css')
    .injectManifest({
        swSrc: './resources/js/service-worker.js'
    });

mix.webpackConfig({
    output: {
        publicPath: ''
    }
    });
      





    

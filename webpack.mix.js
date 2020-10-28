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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/css/app.sass', 'public/css').generateSW({
        // Do not precache images
        exclude: [/\.(?:png|jpg|jpeg|svg)$/],

        // Define runtime caching rules.
        runtimeCaching: [{
            // Match any request that ends with .png, .jpg, .jpeg or .svg.
            urlPattern: /\.(?:png|jpg|jpeg|svg)$/,

            // Apply a cache-first strategy.
            handler: 'CacheFirst',

            options: {
                // Use a custom cache name.
                cacheName: 'images',

                // Only cache 10 images.
                expiration: {
                    maxEntries: 10,
                },
            },
        }],

        skipWaiting: true
    });

    mix.webpackConfig({
        output: {
          publicPath: ''
        }
      });
      





    
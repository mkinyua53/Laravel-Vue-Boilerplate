const mix = require('laravel-mix');
// require('laravel-mix-polyfill');
var SWPrecacheWebpackPlugin = require('sw-precache-webpack-plugin');
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

mix.js('resources/assets/js/app.js', 'public/js')
   .extract(['vue', 'vuex', 'vuetify', 'vue-resource', 'vue-router'])
   .sass('resources/assets/sass/app.scss', 'public/css')
   .browserSync('localhost:8000');

if (mix.inProduction()) {
   mix.version();
}


mix.webpackConfig({
   plugins: [
      new SWPrecacheWebpackPlugin(
         {
            cacheId: 'amate',
            filename: 'service-worker.js',
            handleFetch: process.env.NODE_ENV === 'production',
            clientsClaim: true,
            skipWaiting: true,
            maximumFileSizeToCacheInBytes: process.env.NODE_ENV === 'production' ? 8194304 : 1500000,
            minify: true,
            dynamicUrlToDependencies: {
               '/': ['resources/views/welcome.blade.php'],
               'fonts/fontawesome-webfont.eot': ['public/fonts/fontawesome-webfont.eot'],
               'fonts/fontawesome-webfont.svg': ['public/fonts/fontawesome-webfont.svg'],
               'fonts/fontawesome-webfont.ttf': ['public/fonts/fontawesome-webfont.ttf'],
               'fonts/fontawesome-webfont.woff2': ['public/fonts/fontawesome-webfont.woff2'],
               'fonts/fontawesome-webfont.woff': ['public/fonts/fontawesome-webfont.woff'],
               'fonts/MaterialIcons-Regular.eot': ['public/fonts/MaterialIcons-Regular.eot'],
               'fonts/MaterialIcons-Regular.ttf': ['public/fonts/MaterialIcons-Regular.ttf'],
               'fonts/MaterialIcons-Regular.woff2': ['public/fonts/MaterialIcons-Regular.woff2'],
               'fonts/MaterialIcons-Regular.woff': ['public/fonts/MaterialIcons-Regular.woff'],
               'fonts/Philosopher-Regular.ttf': ['public/fonts/Philosopher-Regular.ttf'],
               'fonts/Grenze-Regular.ttf': ['public/fonts/Grenze-Regular.ttf'],
               'fonts/Raleway-Regular.ttf': ['public/fonts/Raleway-Regular.ttf']
            },
            runtimeCaching: [
               {
                  handler: 'cacheFirst',
                  urlPattern: /fonts\/.*$/,
               },
               {
                  handler: 'cacheFirst',
                  urlPattern: /uploads\/.*$/
               },
               {
                  handler: 'cacheFirst',
                  urlPattern: /images\/.*$/
               },
               {
                  handler: 'fastest',
                  urlPattern: /api\/.*$/
               },
               {
                  handler: 'cacheFirst',
                  urlPattern: /https:\/\/www.google-analytics.com\/analytics.js/
               },
               {
                  handler: 'cacheFirst',
                  urlPattern: /js\/.*$/
               },
               {
                  handler: 'fastest',
                  urlPattern: /css\/.*$/
               }
            ],
         }
      ),
   ]
});

const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss')

mix.js('resources/assets/' + process.env.APP_ADMIN_DIR + '/js/app.js', 'assets/' + process.env.APP_ADMIN_DIR + '/js')
   .version();

mix.sass('resources/assets/' + process.env.APP_ADMIN_DIR + '/sass/app.scss', 'assets/' + process.env.APP_ADMIN_DIR + '/css')
   .options({
       processCssUrls: false,
       postCss: [
           tailwindcss('./tailwind.config.js')
       ],
   })
   .version();

mix.copyDirectory('resources/assets/' + process.env.APP_ADMIN_DIR + '/images', 'public/assets/' + process.env.APP_ADMIN_DIR + '/images');

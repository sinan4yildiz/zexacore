const mix         = require('laravel-mix');
const tailwindcss = require('tailwindcss')

mix.js('resources/assets/admin/js/app.js', 'assets/' + process.env.APP_ADMIN_DIR + '/js')
   .version();

mix.sass('resources/assets/admin/sass/app.scss', 'assets/' + process.env.APP_ADMIN_DIR + '/css')
   .options({
       processCssUrls: false,
       postCss: [
           tailwindcss('./tailwind.config.js')
       ],
   })
   .version();

mix.copyDirectory('resources/assets/admin/images', 'public/assets/' + process.env.APP_ADMIN_DIR + '/images');
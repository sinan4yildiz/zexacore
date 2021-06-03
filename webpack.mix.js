const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss')


/*
    * Web
    *
* */

// Copy images directory
mix.copyDirectory('resources/assets/web/images', 'public/assets/web/images');


/*
    * Admin
    *
* */

// Compile scripts
mix.js('resources/assets/admin/js/app.js', 'assets/' + process.env.APP_ADMIN_DIR + '/js')
   .version();


// Compile styles
mix.sass('resources/assets/admin/sass/app.scss', 'assets/' + process.env.APP_ADMIN_DIR + '/css')
   .options({
       processCssUrls: false,
       postCss: [
           tailwindcss('./tailwind.config.js')
       ],
   })
   .version();


// Copy images directory
mix.copyDirectory('resources/assets/admin/images', 'public/assets/' + process.env.APP_ADMIN_DIR + '/images');
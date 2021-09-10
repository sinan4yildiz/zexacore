const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');

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

// Scripts
mix.js('resources/assets/admin/vue/application.js', 'assets/' + process.env.APP_ADMIN_DIR + '/js')
  .version();

// Styles
mix.sass('resources/assets/admin/scss/app.scss', 'assets/' + process.env.APP_ADMIN_DIR + '/css')
  .options({
    processCssUrls: false,
    postCss: [
      tailwindcss('./tailwind.config.js'),
    ],
  })
  .version();

// Copy images directory
mix.copyDirectory('resources/assets/admin/images', 'public/assets/' + process.env.APP_ADMIN_DIR + '/images');

// ESLint Loader
/*mix.webpackConfig({
    module: {
        rules: [
            {
                enforce: 'pre',
                test: /\.(js|vue)$/,
                loader: 'eslint-loader',
                exclude: /node_modules/
            }
        ]
    }
})*/

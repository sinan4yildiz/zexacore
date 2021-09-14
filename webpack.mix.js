const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');

/*
* Assets dirs
*
* */
const assets = {
  base: 'resources/assets/',

  path: function (end) {
    return this.base + end;
  },
};

/*
 * Web
 *
 * */

// Copy images directory
mix.copyDirectory(assets.path('web/images'), 'public/assets/web/images');

/*
 * Admin
 *
 * */

// Scripts
mix.js(assets.path('admin/vue/application.js'), 'assets/' + process.env.APP_ADMIN_DIR + '/js')
  .version();

// Styles
mix.sass(assets.path('admin/scss/app.scss'), 'assets/' + process.env.APP_ADMIN_DIR + '/css')
  .options({
    processCssUrls: false,
    postCss: [
      tailwindcss('./tailwind.config.js'),
    ],
  })
  .version();

// Copy images directory
mix.copyDirectory(assets.path('admin/images'), 'public/assets/' + process.env.APP_ADMIN_DIR + '/images');

// Webpack config
mix.webpackConfig({
  resolve: {
    alias: {
      '@assets': path.resolve(__dirname, assets.path('admin/scss')),
      '@': path.resolve(__dirname, assets.path('admin/vue')),
    },
  },
});

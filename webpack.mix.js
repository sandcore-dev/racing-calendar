// eslint-disable-next-line import/no-extraneous-dependencies
const mix = require('laravel-mix');
const config = require('./webpack.config');

mix.webpackConfig(config);

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');

mix.vue();

if (mix.inProduction()) {
    mix.version();
}

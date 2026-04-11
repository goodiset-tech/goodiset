const mix = require('laravel-mix');

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

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        //
    ])
    .sass('public/front/assets/sass/main.scss', 'public/front/assets/sass');

mix.override((webpackConfig) => {
    if (webpackConfig.plugins) {
        webpackConfig.plugins = webpackConfig.plugins.filter(
            (plugin) => !(plugin.constructor && plugin.constructor.name === 'WebpackBarPlugin')
        );
    }
});

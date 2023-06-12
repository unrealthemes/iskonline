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

mix.js([
    'resources/js/app.js',
    'resources/js/calc/suggestions.js',
    'resources/js/inputs.js',
    'resources/js/calc/applicationForm.js',
], 'public/js').js([
    'resources/js/admin/admin.js',
], 'public/js/admin').sass('resources/sass/app.scss', 'public/css')
    .postCss('resources/css/normalize.css', 'public/css')
    .postCss('resources/css/responsive.css', 'public/css')
    .postCss('resources/css/style.css', 'public/css');

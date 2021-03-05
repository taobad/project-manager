let mix = require('laravel-mix');

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

mix.js('resources/assets/js/app.js', 'public/js/app.js')
    .scripts('resources/assets/js/theme.js', 'public/js/theme.js')
    .scripts('node_modules/frappe-gantt/dist/frappe-gantt.js', 'public/js/gantt.js')
    .scripts('node_modules/frappe-charts/dist/frappe-charts.min.iife.js', 'public/js/chart.js')
    .scripts('node_modules/easymde/dist/easymde.min.js', 'public/plugins/wysiwyg/easymde.js')
    .postCss('resources/assets/css/tailwind.css', 'public/css/tailwind.css', [
        require('postcss-import'),
        require('tailwindcss'),
    ])
    .sass('resources/assets/sass/login.scss', 'public/css')
    .sass('resources/assets/sass/app.scss', 'public/css')
    .styles([
        'resources/assets/css/bootstrap.css',
        'resources/assets/css/theme.css',
        'resources/assets/css/fa-svg-with-js.css',
        'node_modules/frappe-gantt/dist/frappe-gantt.css',
        'node_modules/easymde/dist/easymde.min.css',
    ], 'public/css/theme.css')
    .scripts([
        'node_modules/pace-js/pace.min.js',
        'node_modules/moment/min/moment.min.js',
        'node_modules/jquery-maskmoney/dist/jquery.maskMoney.min.js',
        'resources/assets/js/plugins.js',
        'resources/assets/js/custom.js',
    ], 'public/js/plugins.js');
mix.copyDirectory('node_modules/bootstrap-markdown-fa5/locale', 'public/plugins/wysiwyg/locale');
mix.copyDirectory('node_modules/summernote/dist/lang', 'public/plugins/wysiwyg/lang')
mix.copy('node_modules/summernote/dist/summernote.min.css', 'public/plugins/wysiwyg/summernote.min.css');
mix.copy('node_modules/fullcalendar/main.min.css', 'public/plugins/calendar/main.min.css');

mix.copy('node_modules/summernote/dist/summernote.min.js', 'public/plugins/wysiwyg/summernote.min.js');
mix.copy('node_modules/bootstrap-markdown-fa5/js/bootstrap-markdown.js', 'public/plugins/wysiwyg/bootstrap-markdown.js');
mix.copy('node_modules/moment/min/locales.min.js', 'public/plugins/moment/locales.min.js');
mix.copy('node_modules/fullcalendar/main.min.js', 'public/plugins/calendar/main.min.js');
mix.copy('node_modules/fullcalendar/locales-all.min.js', 'public/plugins/calendar/locales.all.min.js');
if (mix.inProduction()) {
    mix.version();
}
const elixir = require('laravel-elixir');

require('laravel-elixir-vue');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(mix => {
    mix.sass('app.scss', null, null, {
        includePaths: ['./node_modules/bootstrap-sass/assets/stylesheets/']})

        .copy([
            'node_modules/bootstrap-sass/assets/fonts/**'
        ], 'public/fonts')

        .webpack('app.js','public/js/app.js')

        .styles(['./resources/assets/css/flash/flash.css',
            './node_modules/datatables.net-bs/css/dataTables.bootstrap.css',
            './node_modules/bootstrap-material-design/dist/css/ripples.css',
            './node_modules/bootstrap-material-design/dist/css/bootstrap-material-design.css'
        ],'public/css/style.css')
        .scripts([
            // './node_modules/datatables.net/js/jquery.dataTables.js',
            // './node_modules/bootstrap-material-design/dist/js/ripples.js',
            'flash/flash.js'],'public/js/app.js');
});

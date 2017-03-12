const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application as well as publishing vendor resources.
 |
 */

elixir.config.sourcemaps = false;

elixir((mix) => {
    mix.sass('app.scss', 'resources/assets/css/app.css')
        .sass('common.scss', 'resources/assets/css/common.css')
        .sass('font-awesome.scss', 'resources/assets/css/font-awesome.css')
        .sass('web/forum/index.scss', 'resources/assets/css/web/forum/index.css')
        .sass('web/user/register.scss', 'resources/assets/css/web/user/register.css')
        .sass('web/user/login.scss', 'resources/assets/css/web/user/login.css')
        .sass('web/forum/show.scss', 'resources/assets/css/web/forum/show.css')
        .sass('web/forum/create.scss', 'resources/assets/css/web/forum/create.css')
        .sass('web/ranking/show.scss', 'resources/assets/css/web/ranking/show.css')
        .sass('web/ranking/rankinglist.scss', 'resources/assets/css/web/ranking/rankinglist.css');

    mix.styles([
        'app.css',
        'common.css',
        'font-awesome.css',
        'web/forum/index.css',
        'web/forum/show.css',
        'web/forum/create.css',
        'web/user/register.css',
        'web/user/login.css',
        'web/ranking/show.css',
        'web/ranking/rankinglist.css',
    ], 'public/web/css/all.css');
    
    // mix.version('css/all.css');
    
    // mix.browserSync();

    // mix.webpack('app.js');
});

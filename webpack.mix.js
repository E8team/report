const { mix } = require('laravel-mix');


mix.js('resources/assets/front/js/app.js', 'public/static/front/js')
    .js('resources/assets/admin/js/app.js', 'public/static/admin/js')
    .version();
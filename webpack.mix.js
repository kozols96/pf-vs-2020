let mix = require('laravel-mix');

mix
    .js('resources/js/app.js', 'public/assets/script.js')
    .sass('resources/styles/app.scss', 'public/assets/style.css');
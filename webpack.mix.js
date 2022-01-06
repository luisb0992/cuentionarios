const mix = require('laravel-mix');


mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sourceMaps();

// Archivos para el funcionamiento de la landing page
mix.js('resources/js/landing/landing.js', 'public/js/landing').vue();

const mix = require("laravel-mix");

mix.js("resources/js/app.js", "public/js")
    .sass("resources/sass/app.scss", "public/css")
    .sass("resources/css/custom.scss", "public/css")
    .sourceMaps();

// Copia las librerias necesarias para el funcionamiento de la app
mix.copyDirectory("resources/libs", "public/libs");

// Archivos para el funcionamiento de la landing page
mix.js("resources/js/landing/landing.js", "public/js/landing").vue();

// Archivos para el funcionamiento del modulo de fases
mix.js("resources/js/phases/create.js", "public/js/phases")
    .js("resources/js/phases/edit.js", "public/js/phases")
    .js("resources/js/phases/index.js", "public/js/phases")
    .vue();

// versionar enj producción
if (mix.inProduction()) {
    mix.version();
}

// recargar automaticamente con browsersync
// @see https://browsersync.io/docs/options
if (!mix.inProduction()) {
    // mix.browserSync({
    //     proxy: process.env.MIX_APP_URL,
    // });

    // desactivar notificaciones
    // mix.disableNotifications();
}

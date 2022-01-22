<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Comparte el usuario en todas las vistas de blade
        // El usuario registrado o el usuario invitado, según sea el caso
        View::composer('*', fn ($view) => $view->with('user', Auth::user() ?? null));

        // Obtener la ruta absoluta donde se encuentran los videos subidos
        $path = env('APP_URL') . '/storage/' . config('videos.folder') . '/';
        View::composer('*', fn ($view) => $view->with('path_videos', $path));

        // Usa los estilos CSS de Bootstrap para el paginador
        Paginator::useBootstrap();

        // heroku
        if (env('REDIRECT_HTTPS')) {
            $this->app['request']->server->set('HTTPS', true);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        $this->bladeDirectives();

        // heroku
        if (env('REDIRECT_HTTPS')) {
            $url->formatScheme('https://');
        }
    }

    /**
     * Directivas para blade
     *
     * @return void
     */
    public function bladeDirectives(): void
    {
        // @json($object)
        //
        // @param object $object            El objeto a representar como json
        //
        // Representa un objeto en forma de json
        Blade::directive('json', function ($object) {
            return "<?php
                echo htmlentities(json_encode($object));
            ?>";
        });
    }
}

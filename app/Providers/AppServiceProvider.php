<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
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

        // Usa los estilos CSS de Bootstrap para el paginador
        Paginator::useBootstrap();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
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

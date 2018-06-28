<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';
    protected $namespaceapi = 'App\Http\Controllers\API';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        Route::pattern('id','[0-9]+');
        Route::pattern('icao','[A-Za-z0-9]{3,4}');
        Route::pattern('callsign', '[A-Z]{3}[0-9]{1,4}');

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        if (env('APP_ENV') == "dev") {
            Route::domain("www.northeastva.devel")
                ->middleware(["web"])
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        } else {
            Route::domain("www.northeastva.org")
                ->middleware(["web"])
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        }
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        if (env('APP_ENV') == "dev") {
            Route::domain("api.northeastva.devel")
                ->middleware(["web","api"])
                ->namespace($this->namespaceapi)
                ->group(base_path('routes/api.php'));
        } else {
            Route::domain("api.northeastva.org")
                ->middleware(["web","api"])
                ->namespace($this->namespaceapi)
                ->group(base_path('routes/api.php'));
        }
    }
}

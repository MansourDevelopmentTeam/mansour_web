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

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

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
        // $this->mapDeliveryApiRoutes();
        $this->mapCustomerApiRoutes();
        $this->mapAdminApiRoutes();


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
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
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
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
    protected function mapAdminApiRoutes()
    {
        Route::prefix('api/admin')
            ->name('admin.')
            ->middleware('api')
            ->namespace($this->namespace.'\Admin')
            ->group(base_path('routes/adminApi.php'));
    }
    protected function mapCustomerApiRoutes()
    {
        Route::prefix('api/customer')
            ->name('customer.')
            ->middleware('api')
            ->namespace($this->namespace.'\Customer')
            ->group(base_path('routes/customerApi.php'));
    }
    protected function mapDeliveryApiRoutes()
    {
        Route::prefix('api/delivery')
            ->middleware('api')
            ->namespace($this->namespace.'\Delivery')
            ->group(base_path('routes/adminApi.php'));
    }
}

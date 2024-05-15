<?php

namespace CongnqNexlesoft\MaintenanceMode\Providers;

use CongnqNexlesoft\MaintenanceMode\Http\Middleware\MaintenanceModeMiddleware;
use Illuminate\Support\ServiceProvider;

class MaintenanceModeServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->middleware([
            MaintenanceModeMiddleware::class,
        ]);
    }
}

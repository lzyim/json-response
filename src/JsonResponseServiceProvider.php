<?php

namespace Soloslee\JsonResponse;

use Illuminate\Support\ServiceProvider;

class JsonResponseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('json', function () {
            return new JsonResponse;
        });
    }
}
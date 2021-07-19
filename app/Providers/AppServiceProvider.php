<?php

namespace App\Providers;

use App\Services\HousesService;
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
        // Force jetstream to use https
        // see: https://stackoverflow.com/questions/67184333/laravel-jetstream-fortify-force-ssl-or-https
        if (App::environment('production')) {
            $this->app['request']->server->set('HTTPS', true);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind('App\Services\HousesService', fn($app) => new HousesService());
        //
    }
}

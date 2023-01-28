<?php

namespace App\Providers;

use App\Generators\UniqueIdGenerator;
use Illuminate\Support\ServiceProvider;

class GeneratorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->bind(UniqueIdGenerator::class, static function ($app) {
            return new UniqueIdGenerator($app['config']['generators']['short_code']['max_length']);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

<?php

namespace App\Providers;

use App\Generators\ShortCodeGenerator;
use Illuminate\Support\ServiceProvider;

class GeneratorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->bind(ShortCodeGenerator::class, static function ($app) {
            return new ShortCodeGenerator(characterSet: $app['config']['generators.short_code.character_set']);
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

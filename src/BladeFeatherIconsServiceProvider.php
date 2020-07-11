<?php

namespace Brunocfalcao\BladeFeatherIcons;

use BladeUI\Icons\Factory;
use Illuminate\Support\ServiceProvider;

class BladeFeatherIconsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->callAfterResolving(Factory::class, function (Factory $factory) {
            $factory->add('feather-icons', [
                'path' => __DIR__ . '/../resources/svg',
                'prefix' => 'feathericon',
            ]);
        });
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../resources/svg' => public_path('vendor/brunocfalcao/blade-feather-icons'),
            ], 'blade-feather-icons');
        }
    }
}

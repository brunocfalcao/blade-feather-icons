<?php

namespace Brunocfalcao\BladeFeatherIcons;

use BladeUI\Icons\Factory;
use Illuminate\Support\ServiceProvider;

class BladeFeatherIconsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->make(Factory::class)->add('feather-icons', [
            'path' => __DIR__ . '/../resources/svg',
            'prefix' => 'feathericon',
        ]);

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../resources/svg' => public_path('vendor/blade-feather-icons'),
            ], 'blade-feather-icons');
        }
    }
}

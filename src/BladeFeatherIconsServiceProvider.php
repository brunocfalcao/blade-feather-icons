<?php

declare(strict_types=1);

namespace Brunocfalcao\BladeFeatherIcons;

use BladeUI\Icons\Factory;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;

final class BladeFeatherIconsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerConfig();

        $this->callAfterResolving(Factory::class, function (Factory $factory, Container $container): void {
            $config = $container->make('config')->get('blade-feather-icons', []);

            $factory->add('feather-icons', array_merge([
                'path' => __DIR__ . '/../resources/svg',
            ], $config));
        });
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/blade-feather-icons.php' => $this->app->configPath('blade-feather-icons.php'),
            ], 'blade-feather-icons-config');

            $this->publishes([
                __DIR__ . '/../resources/svg' => $this->app->publicPath('vendor/feather-icons'),
            ], 'blade-feather-icons');

            $this->commands([
                Commands\SyncIconsCommand::class,
            ]);
        }
    }

    private function registerConfig(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/blade-feather-icons.php',
            'blade-feather-icons'
        );
    }
}

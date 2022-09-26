<?php

namespace Litermi\SimpleNotification\Providers;

use Litermi\SimpleNotification\Services\SendSimpleNotificationService;

/**
 *
 */
class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {

        $this->app->bind('simple-notification-service', function()
        {
            return new SendSimpleNotificationService();
        });

        $this->mergeConfig();
    }

    public function boot()
    {
        $this->publishConfig();
        $this->publishMigrations();
    }

    private function mergeConfig()
    {
        $this->mergeConfigFrom($this->getConfigPath(), 'simple-notification');
    }

    private function publishConfig()
    {
        // Publish a config file
        $this->publishes([ $this->getConfigPath() => config_path('simple-notification.php'), ], 'config');
    }

    private function publishMigrations()
    {
//        $path = $this->getMigrationsPath();
//        $this->publishes([$path => database_path('migrations')], 'migrations');
    }

    /**
     * @return string
     */
    private function getConfigPath()
    {
        return __DIR__ . '/../../config/simple-notification.php';
    }

    /**
     * @return string
     */
    private function getMigrationsPath()
    {
        return __DIR__ . '/../database/migrations/';
    }
}

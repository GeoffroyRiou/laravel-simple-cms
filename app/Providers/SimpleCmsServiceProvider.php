<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\MenuService;
use App\Services\ReflectionService;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class SimpleCmsServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        // Bind the ReflectionService
        $this->app->singleton(ReflectionService::class, function ($app) {
            return new ReflectionService();
        });

        // Bind the MenuService
        $this->app->singleton(MenuService::class, function ($app) {
            return new MenuService($app->make(ReflectionService::class));
        });
    }

    public function boot(): void
    {

        /**
         * Views
         */

        Blade::anonymousComponentPath(resource_path('views/simple-cms'), 'simple-cms');
    }
}

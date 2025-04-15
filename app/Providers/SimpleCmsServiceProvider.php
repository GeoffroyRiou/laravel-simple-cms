<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Setting;
use App\Services\ImageService;
use App\Services\MenuService;
use App\Services\ReflectionService;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class SimpleCmsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Bind the ReflectionService
        $this->app->singleton(ReflectionService::class, fn ($app): \App\Services\ReflectionService => new ReflectionService);

        // Bind the MenuService
        $this->app->singleton(MenuService::class, fn ($app): \App\Services\MenuService => new MenuService($app->make(ReflectionService::class)));

        // Bind the ImageService
        $this->app->bind('imageHelper', fn ($app): \App\Services\ImageService => new ImageService);
    }

    public function boot(): void
    {

        /**
         * Views
         */

        // Blade::componentNamespace('App\\View\\Components\\SimpleCms', 'simple-cms');

        // Inject settings to all views
        if (! $this->app->runningInConsole()) {

            $settings = Setting::all()->flatMap(fn ($setting) => [
                $setting->slug => $setting->toArray(),
            ]);

            View::share('settings', $settings);
        }
    }
}

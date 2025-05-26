<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Setting;
use App\Services\ImageService;
use App\Services\MenuService;
use App\Services\PreloadResourcesService;
use App\Services\ReflectionService;
use App\Services\SitemapService;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class SimpleCmsServiceProvider extends ServiceProvider
{
    use \Mcamara\LaravelLocalization\Traits\LoadsTranslatedCachedRoutes;

    public function register(): void
    {
        // Bind the ReflectionService
        $this->app->singleton(ReflectionService::class, fn($app): \App\Services\ReflectionService => new ReflectionService);

        // Bind the MenuService
        $this->app->singleton(MenuService::class, fn($app): \App\Services\MenuService => new MenuService($app->make(ReflectionService::class)));

        // Bind the PreloadService
        $this->app->singleton(PreloadResourcesService::class, fn($app): \App\Services\PreloadResourcesService => new PreloadResourcesService);

        // Bind the ImageService
        $this->app->bind('imageHelper', fn($app): \App\Services\ImageService => new ImageService);

        // Bind the SitemapService
        $this->app->bind('sitemap', fn($app): \App\Services\SitemapService => new SitemapService($app->make(MenuService::class)));
    }

    public function boot(): void
    {
        /**
         * Assets
         */
        FilamentAsset::register([
            Css::make('admin-style', __DIR__ . '/../../resources/css/admin.css'),
        ]);

        /**
         * Routes
         */
        RouteServiceProvider::loadCachedRoutesUsing(fn() => $this->loadCachedRoutes());

        /**
         * Views
         */

        // Inject settings to all views
        if (! $this->app->runningInConsole()) {

            $settings = Setting::all()->flatMap(fn($setting) => [
                $setting->slug => $setting,
            ]);

            View::share('settings', $settings);
        }
    }
}

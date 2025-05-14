<?php

declare(strict_types=1);

use App\Services\PreloadResourcesService;

if (! function_exists('preloadResourceService')) {
    function preloadResourceService(): PreloadResourcesService
    {
        return app(PreloadResourcesService::class);
    }
}

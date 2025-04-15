<?php

declare(strict_types=1);

namespace App\Services;

final class PreloadResourcesService
{
    private array $resources = [];

    // Register preload resource from url
    public function registerResource(string $url, string $type): void
    {
        $this->resources[] = [
            'url' => $url,
            'type' => $type,
        ];
    }

    public function getResourcesToPreload(): array
    {
        return $this->resources;
    }
}

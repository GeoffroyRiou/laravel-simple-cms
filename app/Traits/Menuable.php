<?php

declare(strict_types=1);

namespace App\Traits;

trait Menuable
{
    public static function getModelLabel(): string
    {
        return __('Page');
    }

    public static function getLabelKey(): string
    {
        return 'title';
    }

    abstract public function getUrl(): string;
}

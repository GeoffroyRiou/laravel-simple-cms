<?php

declare(strict_types=1);

namespace App\Enums;

enum ResourceTypes: string
{
    case IMAGE = 'image';
    case STYLE = 'style';
    case SCRIPT = 'script';

    public function label(): string
    {
        return match ($this) {
            self::IMAGE => __('Image'),
            self::STYLE => __('Style'),
            self::SCRIPT => __('Script'),
        };
    }
}

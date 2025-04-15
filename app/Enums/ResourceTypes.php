<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\ExtendedEnum;

enum SettingTypes: string
{
    use ExtendedEnum;

    case IMAGE = 'image';
    case STYLE = 'style';
    case SCRIPT = 'script';
}

<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\ExtendedEnum;

enum SettingTypes: string
{
    use ExtendedEnum;

    case TEXT = 'Text';
    case EMAIL = 'Email';
    case PHONE = 'Phone';
    case TEXTAREA = 'Text area';
}

<?php

declare(strict_types=1);

namespace App\Enums;

enum SettingTypes: string
{
    case TEXT = 'Text';
    case EMAIL = 'Email';
    case PHONE = 'Phone';
    case TEXTAREA = 'Text area';

    public function label(): string
    {
        return match ($this) {
            self::TEXT => __('Text'),
            self::EMAIL => __('Email'),
            self::PHONE => __('Phone'),
            self::TEXTAREA => __('Text area'),
        };
    }

    public static function getSelectOptions(): array
    {
        $options = [];

        foreach (self::cases() as $case) {
            $options[$case->value] = $case->label();
        }

        return $options;
    }
}

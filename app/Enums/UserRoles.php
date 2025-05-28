<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Définit les types de status pour les posts
 */
enum UserRoles: string
{
    case Standard = 'standard';
    case Admin = 'admin';

    public function label(): string
    {
        return match ($this) {
            self::Standard => 'Standard',
            self::Admin => 'Admin',
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

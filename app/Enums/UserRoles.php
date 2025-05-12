<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Définit les types de status pour les posts
 */
enum UserRoles: string
{
    use \App\Traits\ExtendedEnum;

    case Standard = 'standard';
    case Admin = 'admin';

    public function label(): string
    {
        return match ($this) {
            self::Standard => 'Standard',
            self::Admin => 'Admin',
        };
    }
}

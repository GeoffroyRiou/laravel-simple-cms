<?php

declare(strict_types=1);

namespace App\Traits;

trait ExtendedEnum
{
    /**
     * Retourne les valeurs d'un enum d'un tableau
     *
     * @param  array<int,BackedEnum>  $enumValues  Le résultat de la méthode cases() appelée sur un enum
     * @param  bool  $valuesAsKeys  La valeur sera utilisée en tant que clé du tableau plutôt qu'un index
     * @return array<int,string>
     */
    public static function getAllEnumValues(bool $valuesAsKeys = true): array
    {
        $roles = [];

        foreach (self::cases() as $key => $case) {
            $roles[$valuesAsKeys ? $case->value : $key] = __($case->value);
        }

        return $roles;
    }
}

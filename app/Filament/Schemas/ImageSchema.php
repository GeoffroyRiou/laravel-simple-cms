<?php

declare(strict_types=1);

namespace App\Filament\Schemas;

use App\Filament\Fields\MediaField;

class ImageSchema
{
    public static function make(
        string $fieldName = 'image',
        string $label = 'Image',
        bool $multiple = false,
        bool $required = false,
        int $max = 0,
    ): array {
        return [
           MediaField::make($fieldName)
                ->label($label)
                ->required($required)
                ->imagesOnly(true)
                ->multiple($multiple)
                ->max($max)
                ->columnSpanFull(),
        ];
    }
}

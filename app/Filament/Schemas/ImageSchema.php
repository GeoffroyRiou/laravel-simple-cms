<?php

declare(strict_types=1);

namespace App\Filament\Schemas;

use Filament\Forms\Components\FileUpload;

class ImageSchema
{
    public static function make(
        string $fieldName = 'image',
        string $label = 'Image',
    ): array {
        return [
            FileUpload::make($fieldName)
                ->label($label)
                ->image()
                ->maxSize(5120)
                ->columnSpanFull(),
        ];
    }
}

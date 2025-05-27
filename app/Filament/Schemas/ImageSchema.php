<?php

declare(strict_types=1);

namespace App\Filament\Schemas;

use App\Filament\Fields\MediaField;
use Filament\Forms\Components\FileUpload;

class ImageSchema
{
    public static function make(
        string $fieldName = 'image',
        string $label = 'Image',
        bool $isRequired = false
    ): array {
        return [
            MediaField::make($fieldName)
                ->label($label)
                ->required($isRequired)
                ->imagesOnly()
                ->columnSpanFull(),
        ];
    }
}

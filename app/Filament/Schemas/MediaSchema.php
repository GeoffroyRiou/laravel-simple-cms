<?php

declare(strict_types=1);

namespace App\Filament\Schemas;

use App\Filament\Fields\MediaField;
use Filament\Forms\Components\FileUpload;

class MediaSchema
{
    public static function make(
        string $fieldName = 'image',
        string $label = 'Image',
        bool $multiple = false,
        bool $imagesOnly = false,
        bool $filesOnly = false,
        int $max = 0,
    ): array {

        $field = FileUpload::make($fieldName)
                    ->label($label)
                    ->maxSize(5120)
                    ->columnSpanFull()
                    ->panelLayout(null)
                    ->multiple($multiple)
                    ->storeFileNamesIn('attachment_file_names')
                    ->required()
                    ->panelLayout(null);
        
        if($imagesOnly){
            $field->image();
        }
        
        if($max > 0){
            $field->maxFiles($max);
        }

        return [
            $field
        ];
    }
}

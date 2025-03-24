<?php

declare(strict_types=1);

namespace App\Filament\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;

class SpacerSchema
{
    public static function make(): array
    {
        return [
            Select::make('spacer')
                ->label(__('Vertical spacing'))
                ->options(config('simple-cms.spacers'))
                ->default('')
                ->selectablePlaceholder(false)
        ];
    }
}

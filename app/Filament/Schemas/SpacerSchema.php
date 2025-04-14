<?php

declare(strict_types=1);

namespace App\Filament\Schemas;

use Filament\Forms\Components\Select;

class SpacerSchema
{
    public static function make(): array
    {

        $topOptions = [
            '' => __('None'),
            ...config('simple-cms.spacers.top'),
        ];

        $bottomOptions = [
            '' => __('None'),
            ...config('simple-cms.spacers.bottom'),
        ];

        return [
            Select::make('topSpacer')
                ->label(__('Top spacing'))
                ->options($topOptions)
                ->default('')
                ->selectablePlaceholder(false),
            Select::make('bottomSpacer')
                ->label(__('Bottom spacing'))
                ->options($bottomOptions)
                ->default('')
                ->selectablePlaceholder(false),
        ];
    }
}

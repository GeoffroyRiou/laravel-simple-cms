<?php

namespace App\Filament\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Get;
use App\Services\MenuService;

class LinkSchema
{
    public static function make(string $fieldname, bool $canChangeColor = false): array
    {
        $menuService = app()->make(MenuService::class);

        $fields = [
            ToggleButtons::make($fieldname.'.type')
                ->label(__('Type'))
                ->options([
                    'page' => __('Page'),
                    'external_link' => __('External link'),
                ])
                ->live()
                ->inline()
                ->required(),
            TextInput::make($fieldname.'.url')
                ->label(__('Url'))
                ->required()
                ->visible(fn(Get $get): bool => $get($fieldname.'.type') == 'external_link'),
            Select::make($fieldname.'.page')
                ->label(__('Page'))
                ->options($menuService->getMenuableModels())
                ->required()
                ->searchable()
                ->visible(fn(Get $get): bool => $get($fieldname.'.type') == 'page')
                ->columnSpanFull(),
            TextInput::make($fieldname.'.label')
                ->label(__('Label'))
                ->visible(fn(Get $get): bool => $get($fieldname.'.type') !== null)
                ->required(),
            Toggle::make($fieldname.'.blank')
                ->label(__('Open in a new tab')),
        ];

        if($canChangeColor){
            $fields[] = Select::make($fieldname.'.variant')
                ->label(__('Appearance'))
                ->options([
                    'primary' => 'Foncée',
                    'primary-invert' => 'Claire',
                ]);
        }

        return $fields;
    }
}

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
    public static function make(string $fieldname = '', bool $canChangeColor = false): array
    {
        $menuService = app()->make(MenuService::class);

        $prefix  = $fieldname ? $fieldname.'' : '';

        $fields = [
            ToggleButtons::make($prefix.'type')
                ->label(__('Type'))
                ->options([
                    'page' => __('Page'),
                    'external_link' => __('External link'),
                ])
                ->live()
                ->inline()
                ->required(),
            TextInput::make($prefix.'url')
                ->label(__('Url'))
                ->required()
                ->visible(fn(Get $get): bool => $get($prefix.'type') == 'external_link'),
            Select::make($prefix.'page')
                ->label(__('Page'))
                ->options($menuService->getMenuableModels())
                ->required()
                ->searchable()
                ->visible(fn(Get $get): bool => $get($prefix.'type') == 'page')
                ->columnSpanFull(),
            TextInput::make($prefix.'label')
                ->label(__('Label'))
                ->visible(fn(Get $get): bool => $get($prefix.'type') !== null)
                ->required(),
            Toggle::make($prefix.'blank')
                ->label(__('Open in a new tab')),
        ];

        if($canChangeColor){
            $fields[] = Select::make($prefix.'variant')
                ->label(__('Appearance'))
                ->options([
                    'primary' => 'Foncée',
                    'primary-invert' => 'Claire',
                ]);
        }

        return $fields;
    }
}

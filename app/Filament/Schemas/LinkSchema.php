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
    public static function make(): array
    {
        $menuService = app()->make(MenuService::class);

        return [
            ToggleButtons::make('type')
                ->label(__('Type'))
                ->options([
                    'page' => __('Page'),
                    'external_link' => __('External link'),
                ])
                ->live()
                ->inline()
                ->required(),
            TextInput::make('url')
                ->label(__('Url'))
                ->required()
                ->visible(fn(Get $get): bool => $get('type') == 'external_link'),
            Select::make('page')
                ->label(__('Page'))
                ->options($menuService->getMenuableModels())
                ->required()
                ->searchable()
                ->visible(fn(Get $get): bool => $get('type') == 'page')
                ->columnSpanFull(),
            TextInput::make('label')
                ->label(__('Label'))
                ->visible(fn(Get $get): bool => $get('type') !== null)
                ->required(),
            Toggle::make('blank')
                ->label(__('Open in a new tab')),
        ];
    }
}

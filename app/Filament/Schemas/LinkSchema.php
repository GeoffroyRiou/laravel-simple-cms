<?php

declare(strict_types=1);

namespace App\Filament\Schemas;

use App\Services\MenuService;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Get;
use Filament\Forms\Set;

class LinkSchema
{
    public static function make(string $fieldname = '', bool $canChangeColor = true, bool $hasIcon = true, ?string $locale = null): array
    {

        $menuService = app()->make(MenuService::class);

        $prefix = $fieldname !== '' && $fieldname !== '0' ? $fieldname.'.' : '';

        $pagesOptions = $menuService->getMenuablesSelectOptionsData(locale: $locale);
        $fields = [
            ToggleButtons::make($prefix.'type')
                ->label(__('Type'))
                ->options([
                    'page' => __('Page'),
                    'external_link' => __('External link'),
                ])
                ->live()
                ->inline()
                ->columnSpanFull()
                ->required(),
            Select::make($prefix.'page')
                ->label(__('Content'))
                ->options($pagesOptions)
                ->required()
                ->searchable()
                ->visible(fn (Get $get): bool => $get($prefix.'type') == 'page')
                ->afterStateUpdated(fn (Set $set, Get $get, ?string $state): mixed => $set($prefix.'label', $pagesOptions[$state] ?? null))
                ->live(onBlur: true),
            TextInput::make($prefix.'url')
                ->label(__('Url'))
                ->required()
                ->visible(fn (Get $get): bool => $get($prefix.'type') == 'external_link'),
            TextInput::make($prefix.'label')
                ->label(__('Label'))
                ->visible(fn (Get $get): bool => $get($prefix.'type') !== null)
                ->required(),
            Toggle::make($prefix.'blank')
                ->label(__('Open in a new tab'))
                ->columnSpanFull(),
        ];

        if ($canChangeColor) {
            $fields[] = Select::make($prefix.'variant')
                ->label(__('Appearance'))
                ->options([
                    'buttondark' => 'Foncée',
                    'buttonlight' => 'Claire',
                ]);
        }

        if ($hasIcon) {
            $fields[] = Select::make($prefix.'icon')
                ->label(__('Icon'))
                ->options(config('simple-cms.icons'));
            $fields[] = Toggle::make($prefix.'iconReverse')
                ->label(__('Icon before label'));
        }

        return $fields;
    }
}

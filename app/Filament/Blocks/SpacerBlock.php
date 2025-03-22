<?php

namespace App\Filament\Blocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Illuminate\Support\Str;

class SpacerBlock
{
    public static function make(): Block
    {
        return Block::make('simple-cms::page-builder.spacer')
            ->icon('heroicon-o-arrows-pointing-out')
            ->label(fn(?array $state): ?string => !empty($state['text']) ? Str::limit($state['text']) : __('Empty spacer'))
            ->schema([
                TextInput::make('text')
                    ->label(__('Text'))
                    ->columnSpanFull(),
                Select::make('bgColor')
                    ->label(__('Background color'))
                    ->options(config('simple-cms.bgColors')),
                Select::make('size')
                    ->label(__('Size'))
                    ->options(config('simple-cms.spacers'))
                    ->required(),
                Toggle::make('darkMode')
                    ->label(__('Dark mode')),
            ])
            ->columns(2);
    }
}

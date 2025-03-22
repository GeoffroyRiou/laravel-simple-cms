<?php

namespace App\Filament\Blocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class SpacerBlock
{
    public static function make(): Block
    {
        return Block::make('simple-cms::page-builder.spacer')
            ->label(__('Spacer'))
            ->icon('heroicon-o-chevron-up-down')
            ->schema([
                TextInput::make('text')
                    ->label(__('Text')),
                Select::make('textColor')
                    ->label('Couleur du texte')
                    ->options(config('simple-cms.textColors')),
                Select::make('bgColor')
                    ->label(__('Background color'))
                    ->options(config('simple-cms.bgColors')),
                Select::make('size')
                    ->label(__('Size'))
                    ->options(config('simple-cms.spacers'))
                    ->required(),
            ])
            ->columns(2);
    }
}

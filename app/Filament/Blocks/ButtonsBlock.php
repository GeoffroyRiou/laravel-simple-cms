<?php

declare(strict_types=1);

namespace App\Filament\Blocks;

use App\Filament\Schemas\LinkSchema;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;

class ButtonsBlock
{
    public static function make(): Block
    {
        return Block::make('simple-cms::page-builder.buttons')
            ->label(__('Buttons'))
            ->icon('heroicon-o-cursor-arrow-rays')
            ->schema([
                Select::make('bgColor')
                    ->label('Couleur de fond')
                    ->options(config('simple-cms.bgColors')),
                Repeater::make('buttons')
                    ->label('')
                    ->schema(
                        LinkSchema::make()
                    )
                    ->columns(2)
                    ->addActionLabel(__('Add a button'))
            ]);
    }
}

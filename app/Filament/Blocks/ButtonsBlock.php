<?php

declare(strict_types=1);

namespace App\Filament\Blocks;

use App\Filament\Schemas\LinkSchema;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Repeater;

class ButtonsBlock
{
    public static function make(): Block
    {
        return Block::make('simple-cms::page-builder.buttons')
            ->label(__('Buttons'))
            ->icon('heroicon-o-cursor-arrow-rays')
            ->schema([
                Repeater::make('buttons')
                    ->label('')
                    ->schema(
                        LinkSchema::make(canChangeColor: true)
                    )
                    ->addActionLabel(__('Add a button'))
            ]);
    }
}

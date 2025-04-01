<?php

declare(strict_types=1);

namespace App\Filament\Blocks;

use App\Filament\Schemas\LinkSchema;
use App\Filament\Schemas\SpacerSchema;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;

class ButtonsBlock
{
    public static function make(): Block
    {
        return Block::make('page-builder.buttons')
            ->label(__('Buttons'))
            ->icon('heroicon-o-cursor-arrow-rays')
            ->schema([
                Select::make('bgColor')
                    ->label('Couleur de fond')
                    ->options(config('simple-cms.bgColors')),
                Section::make(__('Buttons'))
                    ->schema([
                        Repeater::make('buttons')
                            ->label('')
                            ->itemLabel(fn(array $state): ?string => $state['label'] ?? __('Button'))
                            ->schema(
                                LinkSchema::make()
                            )
                            ->cloneable()
                            ->collapsed()
                            ->collapsible()
                            ->columns(2)
                            ->addActionLabel(__('Add a button')),
                    ]),
                Section::make(__('Vertical spacing'))
                    ->schema(SpacerSchema::make())
                    ->collapsible()
                    ->collapsed()
            ]);
    }
}

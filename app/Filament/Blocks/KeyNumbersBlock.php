<?php

declare(strict_types=1);

namespace App\Filament\Blocks;

use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class KeyNumbersBlock
{
    public static function make(): Block
    {
        return Block::make('simple-cms::page-builder.key-numbers')
            ->label(__('Key numbers'))
            ->icon('heroicon-o-presentation-chart-line')
            ->schema([
                Repeater::make('numbers')
                    ->label('')
                    ->itemLabel(fn(array $state): ?string => 'Chiffre clé ' . ($state['number'] ?? ''))
                    ->schema([
                        FileUpload::make('picto')
                            ->label('Pictogramme')
                            ->acceptedFileTypes(['image/svg+xml'])
                            ->maxSize(1024),
                        TextInput::make('number')->label('Chiffre'),
                        TextInput::make('description')->label('Description'),
                    ])
                    ->cloneable()
                    ->collapsed()
                    ->collapsible()
                    ->addActionLabel('Ajouter un chiffre clé'),
                Select::make('bgColor')
                    ->label('Couleur de fond')
                    ->options(config('simple-cms.bgColors')),
            ]);
    }
}

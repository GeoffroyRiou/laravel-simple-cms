<?php

declare(strict_types=1);

namespace App\Filament\Blocks;

use App\Filament\Schemas\ImageSchema;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;

class MultipleImagesBlock
{
    public static function make(): Block
    {
        return Block::make('page-builder.multiple-images')

            ->label('Images multiples')
            ->icon('heroicon-o-rectangle-group')
            ->schema([
                Section::make('')->schema([
                    ...ImageSchema::make('images', 'Images', true),
                    Select::make('positionImages')
                        ->label('Position des images')
                        ->options([
                            'left' => 'À gauche',
                            'center' => 'Au centre',
                            'right' => 'À droite',
                        ])
                        ->columnSpanFull(),
                    Select::make('bgColorTop')
                        ->label('Couleur de fond')
                        ->options(config('simple-cms.bgColors')),
                    Select::make('bgColorBottom')
                        ->label('Couleur de fond')
                        ->options(config('simple-cms.bgColors')),
                ]),
            ]);
    }
}

<?php

namespace App\Filament\Blocks;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;

class RichContentBlock
{
    public static function make(): Block
    {
        return Block::make('simple-cms::page-builder.rich_content')
            ->label(__('Rich Content'))
            ->icon('heroicon-o-newspaper')
            ->schema([
                RichEditor::make('content')->label('')
                    ->required()
                    ->disableToolbarButtons([
                        'attachFiles',
                    ])
                    ->columnSpanFull(),
                Select::make('bgColor')
                    ->label('Couleur de fond')
                    ->options(config('simple-cms.bgColors'))
                    ->columnSpan(1),
                Select::make('bgColorInner')
                    ->label('Couleur de fond interne')
                    ->options(config('simple-cms.bgColors'))
                    ->columnSpan(1),
                Select::make('textColor')
                    ->label('Couleur du texte')
                    ->options(config('simple-cms.textColors'))
                    ->columnSpan(1),
                Toggle::make('textCentered')
                    ->label(__('Text centered'))
                    ->columnSpan(1),
            ])->columns(3);
    }
}

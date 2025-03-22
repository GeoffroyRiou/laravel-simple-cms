<?php

namespace App\Filament\Blocks;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Illuminate\Support\Str;

class RichContentBlock
{
    public static function make(): Block
    {
        return Block::make('simple-cms::page-builder.rich_content')
            ->label(__('Rich Content'))
            ->label( function(?array $state): string {
                return !empty($state['content']) ? Str::limit(strip_tags($state['content']), 50) : __('Rich Content');          
            })
            ->icon('heroicon-o-newspaper')
            ->schema([
                RichEditor::make('content')->label('')
                    ->required()
                    ->disableToolbarButtons([
                        'attachFiles',
                    ])
                    ->columnSpanFull(),
                Toggle::make('textCentered')
                    ->label(__('Text centered'))
                    ->columnSpan(2),
                Select::make('bgColor')
                    ->label('Couleur de fond')
                    ->options(config('simple-cms.bgColors'))
                    ->columnSpan(1),
                Select::make('bgColorInner')
                    ->label('Couleur de fond interne')
                    ->options(config('simple-cms.bgColors'))
                    ->columnSpan(1),
                Toggle::make('darkMode')
                    ->label(__('Dark mode')),
            ])->columns(2);
    }
}

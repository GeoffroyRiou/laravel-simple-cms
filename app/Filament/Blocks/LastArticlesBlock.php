<?php

declare(strict_types=1);

namespace App\Filament\Blocks;

use App\Filament\Schemas\LinkSchema;
use App\Filament\Schemas\SpacerSchema;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;

class LastArticlesBlock
{
    public static function make(): Block
    {
        return  Block::make('page-builder.last-articles')
            ->label(__('Last articles'))
            ->icon('heroicon-o-newspaper')
            ->schema([
                TextInput::make('title')->label(__('Title')),
                RichEditor::make('text')->label(__('Text'))->required(),

                Select::make('bgColor')
                    ->label('Couleur de fond')
                    ->options(config('simple-cms.bgColors')),
                Toggle::make('darkMode')
                    ->label(__('Dark mode'))
                    ->columnSpanFull(),
                Toggle::make('add_button')
                    ->label('Activer le bouton')
                    ->default(false)->live(),
                Section::make('')
                    ->label('Bouton')
                    ->schema(LinkSchema::make('button', canChangeColor: true))
                    ->columns(2)
                    ->visible(fn(Get $get): bool => $get('add_button')),
                Section::make(__('Vertical spacing'))
                    ->schema(SpacerSchema::make())
                    ->collapsible()
                    ->collapsed()
            ]);
    }
}

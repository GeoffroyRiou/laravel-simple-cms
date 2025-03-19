<?php

declare(strict_types=1);

namespace App\Filament\Blocks;

use App\Filament\Schemas\ImageSchema;
use App\Filament\Schemas\LinkSchema;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Get;

class ContentWithImage
{
    public static function make(): Block
    {
        return Block::make('simple-cms::page-builder.content-with-image')
            ->label('Contenu avec image')
            ->icon('heroicon-o-rectangle-group')
            ->schema([

                Section::make('')->schema(
                    array_merge(
                        ImageSchema::make(),
                        [

                            Toggle::make('image_right')
                                ->label('Image à droite')
                                ->default(false),
                            Toggle::make('image_full')
                                ->label('Image couvrante')
                                ->default(false),
                        ]
                    )
                ),

                Section::make('')->schema([
                    TextInput::make('title')
                        ->label('Titre'),
                    RichEditor::make('text')
                        ->label('Texte')
                        ->required(),
                    Select::make('bgColor')
                        ->label('Couleur de fond')
                        ->options(config('simple-cms.bgColors'))
                        ->required(),
                    Select::make('textColor')
                        ->label('Couleur du texte')
                        ->options(config('simple-cms.textColors'))
                        ->required(),
                ]),

                Toggle::make('add_button')
                    ->label('Activer le bouton')
                    ->default(true)->live(),
                Section::make('')
                    ->label('Bouton')
                    ->schema(LinkSchema::make('button', canChangeColor: true))
                    ->visible(fn(Get $get): bool => $get('add_button')),
            ]);
    }
}

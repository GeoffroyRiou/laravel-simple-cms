<?php

declare(strict_types=1);

namespace App\Filament\Blocks;

use App\Filament\Schemas\ImageSchema;
use App\Filament\Schemas\LinkSchema;
use App\Filament\Schemas\SpacerSchema;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Illuminate\Support\Str;

class ContentWithImageBlock
{
    public static function make(): Block
    {
        return Block::make('page-builder.content-with-image')

            ->label(fn(?array $state): string => empty($state['title']) ? __('Content with image') : Str::limit(strip_tags((string) $state['title']), 50))
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
                )
                    ->columns(2),

                Section::make('')->schema([
                    TextInput::make('title')
                        ->label('Titre')
                        ->columnSpanFull(),
                    RichEditor::make('text')
                        ->label('Texte')
                        ->required()
                        ->columnSpanFull(),
                    Select::make('bgColor')
                        ->label('Couleur de fond')
                        ->options(config('simple-cms.bgColors')),
                    Toggle::make('darkMode')
                        ->label(__('Dark mode'))
                        ->columnSpanFull(),
                ])
                    ->columns(2),

                Toggle::make('add_button')
                    ->label('Activer le bouton')
                    ->default(false)->live(),
                Section::make('')
                    ->label('Bouton')
                    ->schema(LinkSchema::make('button', canChangeColor: true))
                    ->columns(2)
                    ->visible(fn (Get $get): bool => $get('add_button')),
                Section::make(__('Vertical spacing'))
                    ->schema(SpacerSchema::make())
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}

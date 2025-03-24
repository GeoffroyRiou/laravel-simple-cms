<?php

declare(strict_types=1);

namespace App\Filament\Blocks;

use App\Filament\Schemas\ImageSchema;
use App\Filament\Schemas\SpacerSchema;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;

class TeamBlock
{
    public static function make(): Block
    {
        return Block::make('simple-cms::page-builder.team')
            ->label(__('Team'))
            ->icon('heroicon-o-user-group')
            ->schema([
                Select::make('bgColor')
                    ->label('Couleur de fond')
                    ->options(config('simple-cms.bgColors'))
                    ->columnSpan(1),
                Repeater::make('members')
                    ->label('')
                    ->itemLabel(fn(array $state): ?string => $state['firstname'] ?? 'Membre')
                    ->schema([
                        Section::make('')
                            ->schema(
                                ImageSchema::make()
                            ),
                        TextInput::make('name')
                            ->label(__('Name'))
                            ->required(),
                        TextInput::make('job')
                            ->label(__('Job'))
                            ->required(),
                        RichEditor::make('text')
                            ->label(__('Text'))
                            ->required(),
                    ])
                    ->cloneable()
                    ->collapsed()
                    ->collapsible()
                    ->addActionLabel(__('Add a member')),
                Section::make(__('Vertical spacing'))
                    ->schema(SpacerSchema::make())
                    ->collapsible()
                    ->collapsed()
            ]);
    }
}

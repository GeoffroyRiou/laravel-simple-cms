<?php

declare(strict_types=1);

namespace App\Filament\Blocks;

use App\Filament\Schemas\SpacerSchema;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;

class FAQBlock
{
    public static function make(): Block
    {
        return Block::make('page-builder.faq')
            ->label(__('FAQ'))
            ->icon('heroicon-o-question-mark-circle')
            ->schema([
                Repeater::make('questions')
                    ->label('')
                    ->itemLabel(fn (array $state): string => $state['title'] ?? 'Question')
                    ->schema([
                        TextInput::make('title')->label(__('Title'))->required(),
                        RichEditor::make('text')->label(__('Text'))->required(),
                    ])
                    ->cloneable()
                    ->collapsed()
                    ->collapsible()
                    ->addActionLabel(__('Add another question')),
                Section::make(__('Vertical spacing'))
                    ->schema(SpacerSchema::make())
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}

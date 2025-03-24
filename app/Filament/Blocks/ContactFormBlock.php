<?php

declare(strict_types=1);

namespace App\Filament\Blocks;

use App\Filament\Fields\ContactFormSelect;
use App\Models\ContactForm;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;

class ContactFormBlock
{
    public static function make(): Block
    {
        return Block::make('simple-cms::page-builder.form')
            ->label(function (?array $state): string {
                $form = !empty($state['content']) ? ContactForm::find($state['content']) : null;
                return $form ? $form->name : __('Form');
            })
            ->icon('heroicon-o-envelope')
            ->schema([
                ContactFormSelect::make('content')
                    ->label('')
                    ->required()
                    ->columnSpanFull(),
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
            ])
            ->columns(2);
    }
}

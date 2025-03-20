<?php

declare(strict_types=1);

namespace App\Filament\Blocks;

use App\Filament\Fields\ContactFormSelect;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Select;

class ContactFormBlock
{
    public static function make(): Block
    {
        return Block::make('simple-cms::page-builder.form')
            ->label('Formulaire')
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
            ])
            ->columns(2);
    }
}

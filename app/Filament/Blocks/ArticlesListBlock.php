<?php

declare(strict_types=1);

namespace App\Filament\Blocks;

use App\Filament\Schemas\SpacerSchema;
use Filament\Forms\Components\Builder\Block;

class ArticlesListBlock
{
    public static function make(): Block
    {
        return Block::make('page-builder.articles-list')
            ->label('Liste d\'articles')
            ->icon('heroicon-o-queue-list')
            ->schema([
                ...SpacerSchema::make(),
            ])
            ->columns(2);
    }
}

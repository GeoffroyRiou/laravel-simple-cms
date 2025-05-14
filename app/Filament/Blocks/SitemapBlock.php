<?php

declare(strict_types=1);

namespace App\Filament\Blocks;

use App\Filament\Schemas\SpacerSchema;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Section;

class SitemapBlock
{
    public static function make(): Block
    {
        return Block::make('page-builder.sitemap')
            ->label(__('Sitemap'))
            ->icon('heroicon-o-map')
            ->schema([
                Section::make(__('Vertical spacing'))
                    ->schema(SpacerSchema::make())
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(),
            ])
            ->columns(2);
    }
}

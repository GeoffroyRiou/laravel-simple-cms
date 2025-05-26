<?php

declare(strict_types=1);

namespace App\Filament\Blocks;

use App\Filament\Schemas\ImageSchema as SchemasImageSchema;
use App\Filament\Schemas\SpacerSchema;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;

class FullWidthImageBlock
{
    public static function make(): Block
    {
        return Block::make('page-builder.full-width-image')
            ->label(__('Full width image'))
            ->icon('heroicon-o-photo')
            ->schema(
                ...SchemasImageSchema::make(),
                Select::make('bgColor')
                    ->label('Couleur de fond')
                    ->options(config('simple-cms.bgColors'))
                    ->columnSpan(1),
                Section::make(__('Vertical spacing'))
                    ->schema(SpacerSchema::make())
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(),
            );
    }
}

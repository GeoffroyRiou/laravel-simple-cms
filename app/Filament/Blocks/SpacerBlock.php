<?php

namespace App\Filament\Blocks;

use App\Filament\Schemas\SpacerSchema;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Illuminate\Support\Str;

class SpacerBlock
{
    public static function make(): Block
    {
        return Block::make('simple-cms::page-builder.spacer')
            ->icon('heroicon-o-arrows-pointing-out')
            ->label(function (?array $state): ?string {
                $label = !empty($state['text']) ? Str::limit($state['text']) : __('Empty spacer');

                $label .= !empty($state['size']) ? ' - ' . config('simple-cms.spacers')[$state['size']] : '';
                $label .= !empty($state['bgColor']) ? ', ' . config('simple-cms.bgColors')[$state['bgColor']] : '';

                return $label;
            })
            ->schema(
                array_merge(
                    [
                        TextInput::make('text')
                            ->label(__('Text'))
                            ->columnSpanFull(),
                        Select::make('bgColor')
                            ->label(__('Background color'))
                            ->options(config('simple-cms.bgColors')),
                    ],
                    SpacerSchema::make(),
                    [
                        Toggle::make('darkMode')
                            ->label(__('Dark mode')),
                    ]
                )
            )
            ->columns(2);
    }
}

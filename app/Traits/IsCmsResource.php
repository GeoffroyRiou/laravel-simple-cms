<?php

declare(strict_types=1);

namespace App\Traits;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Concerns\Translatable;
use Filament\Tables\Actions\Action;
use App\Filament\Fields\PageBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

trait IsCmsResource
{

    use Translatable;

    public static function getPageBuilderSection(): Section
    {
        return Section::make('Page Builder')->schema([
            PageBuilder::make('page_blocks')
                ->columnSpanFull()
        ]);
    }

    public static function getCmsSection(): Section
    {
        return Section::make('')
            ->schema([
                Toggle::make('published')
                    ->label(__('Published'))
                    ->default(true)
                    ->columnSpanFull(),
                TextInput::make('title')
                    ->label(__('Title'))
                    ->required()
                    ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state)))
                    ->live(onBlur: true),
                TextInput::make('slug')
                    ->label(__('Slug'))
                    ->required(),
            ]);
    }

    public static function getIllustrationField(): FileUpload
    {
        return FileUpload::make('illustration')
            ->label(__('Illustration'))
            ->image()
            ->maxSize(5 * 1024)
            ->imagePreviewHeight('250')
            ->loadingIndicatorPosition('left')
            ->panelAspectRatio('2:1.2')
            ->panelLayout('integrated')
            ->removeUploadedFileButtonPosition('right')
            ->uploadButtonPosition('left')
            ->uploadProgressIndicatorPosition('left');
    }

    public static function getParentSelectionField(string $modelClass, string $parentModelClass, string $parentKey = 'parent_id', string $labelKey = 'title'): Select
    {
        return Select::make($parentKey)
            ->label(__('Parent'))
            ->options(function (Get $get) use ($modelClass, $parentModelClass, $labelKey) {

                return $parentModelClass::query()
                    ->when($modelClass === $parentModelClass, function (Builder $query) use ($get) {
                        return $query->where('id', '!=', $get('id'));
                    })
                    ->get()
                    ->pluck($labelKey, 'id');
            })
            ->searchable();
    }

    public static function getTableViewPageAction(): Action
    {
        return Action::make('go')
            ->label(__('View page'))
            ->icon('heroicon-o-eye')
            ->url(fn($record) => $record->getUrl());
    }
}

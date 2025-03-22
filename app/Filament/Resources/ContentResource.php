<?php

namespace App\Filament\Resources;

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
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use RalphJSmit\Filament\SEO\SEO;
use Filament\Tables;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

abstract class ContentResource extends Resource
{

    use Translatable;

    protected static bool $shouldRegisterNavigation = false;
    public static bool $hasParent = true;
    public static bool $hasIllustration = true;

    public static function form(Form $form): Form
    {

        // Base Fields
        $formSchema = [
            self::getCmsSection()
                ->columnSpan(2),
        ];

        // Sidebar

        $categoryClass = (new (static::$model))->categoryModel ?? null;

        if (static::$hasParent || $categoryClass || static::$hasIllustration) {

            $sidebarSchema = [];

            if (static::$hasIllustration) {
                $sidebarSchema[] = Section::make()->schema([
                    self::getIllustrationField()
                        ->panelAspectRatio('2:0.6'),
                ]);
            }

            if (static::$hasParent) {
                $sidebarSchema[] = Section::make()->schema([
                    self::getParentSelectionField(static::$model, static::$model),
                ]);
            }

            if ($categoryClass) {
                $sidebarSchema[] = Section::make()->schema([
                    self::getParentSelectionField(static::$model, $categoryClass, 'category_id', sectionLabel: 'Category'),
                ]);
            }

            $formSchema[] = Section::make('')
                ->schema($sidebarSchema)
                ->columnSpan(1);
        }

        // Page Builder
        $formSchema[] = self::getPageBuilderSection();

        // SEO
        $formSchema[] = Section::make('Metas')->schema([
            SEO::make()->columnSpanFull()
        ]);

        return $form
            ->schema($formSchema)
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label(__('Title'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('slug')
                    ->label(__('Path'))
                    ->formatStateUsing(function ($record): string {
                        return $record->url_path;
                    })
                    ->size(TextColumn\TextColumnSize::ExtraSmall)
                    ->color('gray'),
                ToggleColumn::make('published')
                    ->label(__('Published'))
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                self::getTableViewPageAction(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }


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

    public static function getParentSelectionField(string $modelClass, string $parentModelClass, string $parentKey = 'parent_id', string $labelKey = 'title', string $sectionLabel = 'Parent'): Select
    {
        return Select::make($parentKey)
            ->label(__($sectionLabel))
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

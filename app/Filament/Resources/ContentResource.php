<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Fields\PageBuilder;
use App\Models\Content;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

abstract class ContentResource extends Resource
{
    use Translatable;

    protected static bool $shouldRegisterNavigation = false;

    public static bool $hasParent = true;

    public static bool $hasExcerpt = false;

    public static bool $hasIllustration = true;

    public static function form(Form $form): Form
    {
        $formSchema = [];

        // Base Fields
        $formSchema[] = self::getCmsSection()
            ->columnSpan(2)
            ->visible(fn ($record): bool => ! $record || ! $record->is_home);

        // Illustration
        if (static::$hasIllustration) {
            $formSchema[] = Section::make()->schema([
                self::getIllustrationField(),
            ])->columnSpan(1)
                ->visible(fn ($record): bool => ! $record || ! $record->is_home);
        }

        // Excerpt
        if (static::$hasExcerpt) {
            $formSchema[] = Section::make(__('Excerpt'))
                ->schema([
                    Textarea::make('excerpt')
                        ->label('')
                        ->columnSpanFull(),
                ])
                ->collapsible();
        }

        // Page Builder
        $formSchema[] = self::getPageBuilderSection()
            ->collapsible();

        // Custom Fields
        if ($customFields = static::getCustomFields()) {
            $formSchema[] = Section::make(__('Custom fields'))
                ->schema($customFields);
        }

        // SEO
        $formSchema[] = self::getSeoSection()
            ->collapsible()
            ->collapsed();

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
                    ->formatStateUsing(fn ($record): string => $record->url_path ?? '')
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
                Tables\Actions\EditAction::make(),
                Tables\Actions\ReplicateAction::make()
                    ->beforeReplicaSaved(function (Content $replica): void {
                        $replica->slug .= '-2';
                        $replica->title = $replica->title.' - '.__('Copy');
                    })
                    ->visible(fn ($record): bool => ! $record->is_home),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn ($record): bool => ! $record->is_home),
                self::getTableViewPageAction(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    protected static function getCustomFields(): array
    {
        return [];
    }

    public static function getPageBuilderSection(): Section
    {
        return Section::make(__('Page Builder'))->schema([
            PageBuilder::make('page_blocks')
                ->columnSpanFull(),
        ]);
    }

    public static function getCmsSection(): Section
    {
        $sectionSchema = [
            Toggle::make('published')
                ->label(__('Published'))
                ->default(true)
                ->columnSpanFull(),
            TextInput::make('title')
                ->label(__('Title'))
                ->required()
                ->afterStateUpdated(fn (Set $set, Get $get, ?string $state): mixed => $get('slug') ? null : $set('slug', Str::slug($state)))
                ->live(onBlur: true),
            TextInput::make('slug')
                ->label(__('Slug'))
                ->required(),
        ];

        // Hierarchical

        $categoryClass = (new (static::$model))->categoryModel ?? null;

        if (static::$hasParent || $categoryClass) {

            if (static::$hasParent) {
                $sectionSchema[] = self::getParentSelectionField(static::$model, static::$model)->columnSpan(1);
            }

            if ($categoryClass) {
                $sectionSchema[] = self::getParentSelectionField(static::$model, $categoryClass, 'category_id', sectionLabel: 'Category')->columnSpan(1);
            }
        }

        return Section::make('')
            ->schema($sectionSchema)
            ->columns(2);
    }

    public static function getSeoSection(): Section
    {
        $sectionSchema = [
            TextInput::make('seo_title')
                ->label(__('Title')),
            TextArea::make('seo_description')
                ->label(__('Description')),
        ];

        return Section::make(__('Metas'))
            ->schema($sectionSchema);
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
            ->options(fn (Get $get) => $parentModelClass::query()
                ->when($modelClass === $parentModelClass, fn (Builder $query) => $query->where('id', '!=', $get('id')))
                ->get()
                ->pluck($labelKey, 'id'))
            ->searchable();
    }

    public static function getTableViewPageAction(): Action
    {
        return Action::make('go')
            ->label(__('View page'))
            ->icon('heroicon-o-eye')
            ->url(fn ($record) => $record->getUrl())
            ->openUrlInNewTab();
    }
}

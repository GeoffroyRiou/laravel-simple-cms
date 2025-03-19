<?php

namespace App\Filament\Resources;

use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use App\Filament\Resources\CategoryResource\Pages;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use App\Models\Category;
use App\Traits\IsCmsResource;

class CategoryResource extends Resource
{

    use IsCmsResource;

    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-stack';

    public static function getNavigationLabel(): string
    {
        return __('Article categories');
    }
    public static function getModelLabel(): string
    {
        return __('Article categories');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('')->schema([
                    self::getCmsSection()
                        ->columnSpan(2),
                    Select::make('parent_id')
                        ->label(__('Parent'))
                        ->options(function (Get $get) {
                            return self::$model::query()
                                ->where('id', '!=', $get('id'))
                                ->get()
                                ->pluck('title', 'id');
                        })
                        ->searchable()
                        ->columnSpan(1)
                ])->columns(3),
                self::getPageBuilderSection(),
            ]);
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
                    ->label(__('Parent path'))
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
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}

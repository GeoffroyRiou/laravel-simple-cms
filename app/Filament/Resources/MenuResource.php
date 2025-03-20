<?php

namespace App\Filament\Resources;

use Dom\Text;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use App\Filament\Resources\MenuResource\Pages;

use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Filament\Schemas\LinkSchema;
use App\Models\Menu;
use App\Services\MenuService;
use League\CommonMark\Extension\CommonMark\Node\Inline\Link;
use Saade\FilamentAdjacencyList\Forms\Components\AdjacencyList;

class MenuResource extends Resource
{

    use Translatable;

    protected static ?string $model = Menu::class;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';

    public static function form(Form $form): Form
    {
        $menuService = app()->make(MenuService::class);

        return $form
            ->schema([
                TextInput::make('title')
                    ->label(__('Title'))
                    ->required()
                    ->columnSpanFull(),
                AdjacencyList::make('items')
                    ->labelKey('label')
                    ->childrenKey('children')
                    ->form(LinkSchema::make(canChangeColor: false))
                    ->visible(fn(Get $get): bool => $get('id') !== null)
                    ->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label(__('Title'))
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListMenus::route('/'),
            'create' => Pages\CreateMenu::route('/create'),
            'edit' => Pages\EditMenu::route('/{record}/edit'),
        ];
    }
}

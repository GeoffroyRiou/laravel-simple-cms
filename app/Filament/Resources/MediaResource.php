<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MediaResource\Pages;
use App\Filament\Schemas\MediaSchema;
use App\Models\Media;
use App\Services\ImageService;
use App\Services\MediaService;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;

class MediaResource extends Resource
{
    protected static ?string $model = Media::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';

    protected static ?string $navigationLabel = 'Medias';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                ...MediaSchema::make(
                    fieldName: 'path',
                    label: 'Médias',
                    multiple: false,
                ),
                TextInput::make('name')
                    ->label('Nom')
            ]);
    }

    public static function table(Table $table): Table
    {
        $imageService = app(ImageService::class);
        $mediaService = app(MediaService::class);

        return $table
            ->columns([
                ImageColumn::make('path')
                    ->square()
                    ->extraImgAttributes(fn($record) => $imageService->isResizable($record->path) ? [] : ['style' => 'display:none']),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nom du fichier')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Type'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Lien')
                    ->copyableState(fn($record): string => $mediaService->getMediaUrl($record->path))
                    ->formatStateUsing(fn() => __('Copy file link'))
                    ->badge()
                    ->copyable(),
            ])
            ->defaultSort('created_at', 'desc')
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
            'index' => Pages\ListMedia::route('/'),
            'create' => Pages\CreateMedia::route('/create'),
            'edit' => Pages\EditMedia::route('/{record}/edit'),
        ];
    }
}

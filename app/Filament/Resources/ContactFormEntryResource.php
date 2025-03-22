<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactFormEntryResource\Pages;
use App\Filament\Resources\ContactFormEntryResource\RelationManagers;
use App\Models\ContactFormEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ContactFormEntryResource extends Resource
{
    protected static ?string $model = ContactFormEntry::class;

    protected static ?string $navigationGroup = 'Formulaires';

    protected static ?string $modelLabel = 'Entrée de formulaire';

    protected static ?string $navigationLabel = 'Entrées de formulaire';

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';

    protected static ?int $navigationSort = 2;


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')->dateTime('d/m/Y H:i')->label('Date'),
                TextColumn::make('form'),
                TextColumn::make('subject'),
                TextColumn::make('recipients'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->mutateRecordDataUsing(function (array $data): array {
                    $decodedData = json_decode($data['fields']);

                    $html = '';
                    foreach ($decodedData->fields as $label => $valeur) {
                        $html .= '<p><strong>' . $label . '</strong> : ' . (is_array($valeur) ? implode(', ', $valeur) : $valeur) . '</p>';
                    }

                    $data['fields'] = $html;

                    return $data;
                }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('created_at')->label('Date')->date('d/m/Y H:i'),
                TextEntry::make('form'),
                TextEntry::make('subject'),
                TextEntry::make('recipients'),
                ViewEntry::make('fields')
                    ->view('filament.infolists.entries.champs-entree-formulaire')
                    ->columnSpanFull(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactFormEntries::route('/'),
        ];
    }
}

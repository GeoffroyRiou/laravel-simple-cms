<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\ContactFormEntryResource\Pages;
use App\Models\ContactFormEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
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
                TextColumn::make('created_at')
                    ->dateTime('d/m/Y H:i')
                    ->label(__('Date'))
                    ->sortable(),
                TextColumn::make('form')
                    ->label(__('Form'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('subject')
                    ->label(__('Subject'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('recipients')
                    ->label(__('Recipients'))
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->mutateRecordDataUsing(function (array $data): array {
                    $decodedData = json_decode((string) $data['fields']);

                    $html = '';
                    foreach ($decodedData->fields as $fieldData) {
                        $html .= '<p><strong>' . $fieldData->label . '</strong> : ' . (is_array($fieldData->value) ? implode(', ', $fieldData->value) : $fieldData->value) . '</p>';
                    }

                    $data['fields'] = $html;

                    return $data;
                }),
                DeleteAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('created_at')->label('Date')->date('d/m/Y H:i'),
                TextEntry::make('form')
                    ->label(__('Form name')),
                TextEntry::make('subject')
                    ->label(__('Subject')),
                TextEntry::make('recipients')
                    ->label(__('Recipients')),
                ViewEntry::make('fields')
                    ->view('components.forms.entries.infolist-fields')
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

<?php

namespace App\Filament\Resources\MediaResource\Pages;

use App\Filament\Resources\MediaResource;
use App\Filament\Schemas\MediaSchema;
use App\Services\MediaService;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListMedia extends ListRecords
{
    protected static string $resource = MediaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('upload')
            ->label('Ajouter des médias')
            ->icon('heroicon-o-arrow-up-on-square')
            ->form(
                MediaSchema::make(
                    fieldName: 'path',
                    label: 'Médias',
                    multiple: true,
                ) 
            )
            ->action(function (array $data) {
                $mediaService = app(MediaService::class);
                $mediaService->saveUploadedMediasFromFileUploadField($data);
            }),
        ];
    }
}

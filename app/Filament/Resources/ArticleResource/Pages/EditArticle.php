<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Filament\Resources\ArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Pboivin\FilamentPeek\Pages\Actions\PreviewAction;
use Pboivin\FilamentPeek\Pages\Concerns\HasPreviewModal;

class EditArticle extends EditRecord
{
    use EditRecord\Concerns\Translatable;
    use HasPreviewModal;
    
    protected static string $resource = ArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            PreviewAction::make(),
            Actions\LocaleSwitcher::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getPreviewModalView(): ?string
    {
        return $this->record->viewName;
    }

    protected function getPreviewModalDataRecordKey(): ?string
    {
        return 'model';
    }
}

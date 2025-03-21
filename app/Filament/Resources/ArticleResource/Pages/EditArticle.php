<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Filament\Resources\ArticleResource;
use App\Models\Article;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\EditRecord\Concerns\Translatable;
use Pboivin\FilamentPeek\Pages\Actions\PreviewAction;
use Pboivin\FilamentPeek\Pages\Concerns\HasPreviewModal;

class EditArticle extends EditRecord
{

    use Translatable, HasPreviewModal;

    protected static string $resource = ArticleResource::class;

    protected function getPreviewModalView(): ?string
    {
        // This corresponds to resources/views/posts/preview.blade.php
        return (new Article())->getViewName();
    }

    protected function getPreviewModalDataRecordKey(): ?string
    {
        return 'model';
    }

    protected function getHeaderActions(): array
    {
        return [
            PreviewAction::make()
                ->icon('heroicon-o-eye')
                ->color('info'),
            Actions\DeleteAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\PageResource\Pages;

use App\Filament\Resources\PageResource;
use App\Models\Page;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\EditRecord\Concerns\Translatable;
use Pboivin\FilamentPeek\Pages\Actions\PreviewAction;
use Pboivin\FilamentPeek\Pages\Concerns\HasPreviewModal;

class EditPage extends EditRecord
{

    use Translatable, HasPreviewModal;

    protected static string $resource = PageResource::class;

    protected function getPreviewModalView(): ?string
    {
        // This corresponds to resources/views/posts/preview.blade.php
        return (new Page())->getViewName();
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
            Actions\LocaleSwitcher::make(),
            Actions\DeleteAction::make(),
        ];
    }
}

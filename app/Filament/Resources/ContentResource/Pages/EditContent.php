<?php

declare(strict_types=1);

namespace App\Filament\Resources\ContentResource\Pages;

use Filament\Resources\Pages\EditRecord;
use App\Actions\DuplicateLocalizedContentAction;
use Filament\Actions;
use Filament\Actions\DeleteAction;
use Pboivin\FilamentPeek\Pages\Actions\PreviewAction;
use Pboivin\FilamentPeek\Pages\Concerns\HasPreviewModal;

class EditContent extends EditRecord
{
    use EditRecord\Concerns\Translatable;
    use HasPreviewModal;

    protected function getHeaderActions(): array
    {
        $actions = [
            PreviewAction::make(),
        ];
        $availableLocales = config('app.locales');

        if($availableLocales && count(config('app.locales')) > 1) {
            $actions[] = Actions\LocaleSwitcher::make();
            $actions[] = DuplicateLocalizedContentAction::make();
        }

        $actions[] = DeleteAction::make();

        return $actions;
    }

    protected function getPreviewModalView(): ?string
    {
        return $this->record->is_home ? config('simple-cms.home_view_name') : $this->record->viewName;
    }

    protected function getPreviewModalDataRecordKey(): ?string
    {
        return 'model';
    }
}

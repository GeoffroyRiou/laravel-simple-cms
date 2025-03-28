<?php

declare(strict_types=1);

namespace App\Filament\Resources\ContentResource\Pages;

use App\Actions\DuplicateLocalizedContentAction;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions;

abstract class CreateContent extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;
    
    protected function getHeaderActions(): array
    {
        $actions = [];
        $availableLocales = config('app.locales');

        if($availableLocales && count(config('app.locales')) > 1) {
            $actions[] = Actions\LocaleSwitcher::make();
            $actions[] = DuplicateLocalizedContentAction::make();
        }

        return $actions;
    }

}

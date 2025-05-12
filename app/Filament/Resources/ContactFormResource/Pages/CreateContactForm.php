<?php

declare(strict_types=1);

namespace App\Filament\Resources\ContactFormResource\Pages;

use App\Filament\Actions\DuplicateLocalizedContentAction;
use App\Filament\Resources\ContactFormResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateContactForm extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected static string $resource = ContactFormResource::class;

    protected function getHeaderActions(): array
    {
        $actions = [];
        $availableLocales = config('app.locales');

        if ($availableLocales && count(config('app.locales')) > 1) {
            $actions[] = Actions\LocaleSwitcher::make();
            $actions[] = DuplicateLocalizedContentAction::make();
        }

        return $actions;
    }
}

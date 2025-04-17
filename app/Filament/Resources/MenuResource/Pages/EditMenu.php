<?php

declare(strict_types=1);

namespace App\Filament\Resources\MenuResource\Pages;

use App\Filament\Actions\DuplicateLocalizedContentAction;
use App\Filament\Resources\MenuResource;
use Filament\Actions;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\EditRecord\Concerns\Translatable;

class EditMenu extends EditRecord
{
    use Translatable;

    protected static string $resource = MenuResource::class;


    protected function getHeaderActions(): array
    {
        $actions = [];
        
        $availableLocales = config('app.locales');

        if ($availableLocales && count(config('app.locales')) > 1) {
            $actions[] = Actions\LocaleSwitcher::make();
            $actions[] = DuplicateLocalizedContentAction::make();
        }

        $actions[] = DeleteAction::make();

        return $actions;
    }
}

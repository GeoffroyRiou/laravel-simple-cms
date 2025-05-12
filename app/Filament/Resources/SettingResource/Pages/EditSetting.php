<?php

declare(strict_types=1);

namespace App\Filament\Resources\SettingResource\Pages;

use App\Filament\Resources\SettingResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;

class EditSetting extends EditRecord
{
    use EditRecord\Concerns\Translatable;
    
    protected static string $resource = SettingResource::class;

    protected function getHeaderActions(): array
    {
        $actions = [];
        $availableLocales = config('app.locales');

        if ($availableLocales && count(config('app.locales')) > 1) {
            $actions[] = Actions\LocaleSwitcher::make();
        }

        return $actions;
    }
}

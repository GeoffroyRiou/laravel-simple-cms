<?php

declare(strict_types=1);

namespace App\Filament\Actions;

use Filament\Actions\Action;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;

class DuplicateLocalizedContentAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('Duplicate language content'));

        $locales = [];
        foreach (config('app.locales') as $locale) {
            $locales[$locale] = $locale;
        }
        $this->form([
            Section::make()
                ->schema([
                    Radio::make('source_locale')
                        ->label(__('Source language'))
                        ->options($locales)
                        ->required(),
                    Radio::make('destination_locale')
                        ->label(__('Destination language'))
                        ->options($locales)
                        ->required()
                        ->different('source_locale'),
                ])
                ->columns(2)
                ->description(__('Duplicate the content of the source language to the destination language. All destination content wil be replaced by the source content.')),
        ]);

        $this->action(function (array $data, $livewire): void {

            if (empty($livewire->otherLocaleData[$data['destination_locale']])) {
                $livewire->otherLocaleData[$data['destination_locale']] = [];
            }
            if ($livewire->activeLocale === $data['destination_locale']) {
                $livewire->data = $livewire->otherLocaleData[$data['source_locale']];
            } elseif ($livewire->activeLocale === $data['source_locale']) {
                $livewire->otherLocaleData[$data['destination_locale']] = $livewire->data;
            } else {
                $livewire->otherLocaleData[$data['destination_locale']] = $livewire->otherLocaleData[$data['source_locale']];
            }
        });
    }

    public static function getDefaultName(): ?string
    {
        return 'duplicate_localized_content';
    }
}

<?php

declare(strict_types=1);

namespace App\Filament\Fields;

use App\Models\ContactForm;

class ContactFormSelect extends \Filament\Forms\Components\Select
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->options(function (): array {
            $options = [];
            foreach (ContactForm::all() as $form) {
                $options[$form->id] = $form->name;
            }

            return $options;
        });
    }
}

<?php

namespace App\Livewire;

use App\Mail\ContactFormMail;
use App\Models\ContactForm as ContactFormModel;
use App\Models\ContactFormEntry;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithFileUploads;

class ContactForm extends Component
{
    use WithFileUploads;

    public array $rules;

    public ContactFormModel $form;

    public array $formData = [];

    public bool $formSent = false;

    public bool $sendingError = false;

    public function mount(int $formId): void
    {
        $this->form = ContactFormModel::findOrFail($formId);
        $this->prepareForm();
    }

    /**
     * Rempli les propriétés du composant en fonction des fields du formulaire
     */
    private function prepareForm(): void
    {
        foreach ($this->form->fields as $block) {
            switch ($block['type']) {
                case 'choices':
                    switch ($block['data']['type']) {
                        case 'checkbox':
                            $this->formData[$block['data']['slug']] = [];
                            break;
                            // On défini la valeur sélectionnée comme étant la première disponible
                        case 'select':
                            $values = array_keys($block['data']['values']) ?: [];
                            $this->formData[$block['data']['slug']] = $values[0] ?? '';
                            break;
                        default:
                            $this->formData[$block['data']['slug']] = '';
                            break;
                    }
                    break;
                default:
                    $this->formData[$block['data']['slug']] = '';
                    break;
            }
        }
    }

    public function getRules(): array
    {
        $rules = [];
        foreach ($this->form->fields as $champ) {
            $currentRules = [];

            if ($champ['data']['required']) {
                $currentRules[] = 'required';
            }
            if (! empty($champ['data']['mask'])) {
                $currentRules[] = 'regex:/^'.$champ['data']['mask'].'$/i';
            }

            switch ($champ['type']) {
                case 'file':
                    $format = $champ['data']['format'] ?: null;
                    if (! empty($format)) {
                        $currentRules[] = "extensions:{$format}";
                    }
                    break;
            }
            $rules['formData.'.$champ['data']['slug']] = $currentRules;
        }

        return $rules;
    }

    public function send(): void
    {
        $validated = $this->validate($this->getRules());
        $this->sendingError = false;
        $this->formSent = false;

        $formattedData = $this->formatDataForMail($validated['formData']);

        // Création de l'entrée en base

        ContactFormEntry::create([
            'fields' => json_encode($formattedData),
            'subject' => $this->form->subject,
            'recipients' => $this->form->recipients,
            'form' => $this->form->name,
        ]);

        // Envoi du mail
        if (
            Mail::to(explode(',', $this->form->recipients))
                ->send(
                    new ContactFormMail(
                        $this->form->subject ?? '',
                        $formattedData
                    )
                )
        ) {
            $this->formSent = true;

            // Reset du formulaire
            $this->prepareForm();
        } else {
            $this->sendingError = true;
        }
    }

    /**
     * Génère les données pour le mail sous la forme de
     * label => valeur
     */
    private function formatDataForMail(array $validatedData): array
    {
        $mailData = [
            'fields' => [],
            'files' => [],
        ];

        foreach ($validatedData as $key => $value) {
            $champInformations = $this->form->getFieldInformations($key);

            if ($champInformations) {

                if ($champInformations['type'] === 'file' && $value) {
                    $mailData['files'][] = $value->getRealPath();
                } else {

                    if ($value == '0') {
                        $value = 'non';
                    }
                    if ($value == '1') {
                        $value = 'oui';
                    }

                    $mailData['fields'][$champInformations['data']['label'] ?? $key] = $value;
                }
            }
        }

        return $mailData;
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}

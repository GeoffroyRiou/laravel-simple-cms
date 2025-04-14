<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 * @property array $fields
 */
class ContactForm extends Model
{
    use HasTranslations;

    protected $fillable = [
        'name',
        'fields',
        'subject',
        'recipients',
    ];

    public $translatable = [
        'fields',
    ];

    // Transformation du contenu json en tableau
    protected function casts(): array
    {
        return [
            'fields' => 'array',
        ];
    }

    public function getFieldInformations(string $key): ?array
    {

        foreach ($this->fields as $field) {
            if ($field['data']['slug'] === $key) {
                return $field;
            }
        }

        return null;
    }
}

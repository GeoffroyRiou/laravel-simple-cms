<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactFormEntry extends Model
{
    protected $fillable = [
        'form',
        'fields',
        'subject',
        'recipients',
    ];

    protected function casts(): array
    {
        return [
            'fields' => 'array',
        ];
    }
}

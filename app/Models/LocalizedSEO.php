<?php

namespace App\Models;

use RalphJSmit\Laravel\SEO\Models\SEO;
use Spatie\Translatable\HasTranslations;

class LocalizedSEO extends SEO
{
    use HasTranslations;

    protected $translatable = [
        'title',
        'description',
    ];
}

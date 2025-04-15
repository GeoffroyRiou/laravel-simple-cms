<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Menu extends Model
{
    use HasTranslations;

    protected $fillable = [
        'title',
        'items',
    ];

    protected $casts = [
        'items' => 'array',
    ];

    protected $translatable = [
        'items',
    ];

    protected static function booted()
    {
        static::creating(function (Menu $menu): void {

            /**
             * When creating a menu, the plugin used to do it dosn't set all languages
             * It is initialized as null instead of an empty array
             * So we have to set it manually
             */
            foreach (config('app.locales', []) as $locale) {
                $menu->setTranslation('items', $locale, []);
            }
        });
    }
}

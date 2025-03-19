<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use Spatie\Translatable\HasTranslations;

trait IsCmsModel
{

    use Menuable, HasSEO, HasTranslations;

    /**
     * Initialize the IsCmsModel trait.
     * Merge the fillable attributes with the default ones.
     */
    public function initializeIsCmsModel()
    {
        $this->fillable = array_merge(
            $this->fillable,
            [
                'title',
                'slug',
                'url_path',
                'published',
                'page_blocks',
            ]
        );

        $this->casts = array_merge(
            $this->casts,
            [
                'page_blocks' => 'array',
            ]
        );

        $this->translatable = array_merge(
            $this->translatable ?? [],
            [
                'title',
                'slug',
                'page_blocks',
            ]
        );
    }

    public static function bootIsCmsModel()
    {
        static::created(function (Model $model) {
            $model->url_path = $model->getUrlPath();
            $model->save();
        });
        static::updating(function (Model $model) {
            $model->url_path = $model->getUrlPath();
        });
    }

    /**
     * Get the route name for the page.
     */
    public function getRouteName(): string
    {
        return 'cms.cms_model';
    }

    /**
     * Get the route name for the page.
     */
    abstract public function getViewName(): string;

    /**
     * Get the URL for the page.
     */
    public function getUrl(): string
    {
        return url($this->url_path);
    }

    /**
     * Get the URL path for the page.
     */
    public function getUrlPath(): string
    {
        return $this->slug;
    }

    /**
     * Scope a query to only include published pages.
     */
    public function scopePublished(Builder $query): void
    {
        $query->where('published', true);
    }
}

<?php

namespace App\Models;

use App\Traits\Menuable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use Spatie\Translatable\HasTranslations;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

abstract class Content extends Model
{
    use Menuable, HasSEO, HasTranslations, HasRecursiveRelationships;


    public $table = 'contents';
    public $routeName = 'cms.content';
    public $viewName = 'components.pages.default-page';

    protected $fillable = [
        'title',
        'slug',
        'url_path',
        'published',
        'page_blocks',
        'model_path',
        'parent_id',
        'category_id',
        'illustration',
        'is_home',
    ];

    protected $casts = [
        'page_blocks' => 'array',
    ];

    protected $translatable = [
        'title',
        'url_path',
        'page_blocks',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('model_path', function (Builder $builder) {
            $builder->where('model_path', static::class);
        });

        static::creating(function (Model $model) {
            $model->model_path = static::class;
            $model->url_path = $model->getUrlPath();
        });

        static::updating(function (Model $model) {
            $model->model_path = static::class;
            $model->url_path = $model->getUrlPath();
        });
    }

    /**
     * Get the URL for the page.
     */
    public function getUrl(): string
    {
        return url($this->url_path ?? '');
    }

    /**
     * Get the URL path for the page.
     */
    public function getUrlPath(bool $includeSelf = true): string
    {

        if ($this->is_home) {
            return '/';
        }

        if (!empty($this->parent_id)) {
            $method = $includeSelf ? 'ancestorsAndSelf' : 'ancestors';
            return $this->$method()->pluck('slug')->reverse()->implode('/');
        }

        if (!empty($this->category_id)) {
            $ancestorsPath = $this->ancestors()->pluck('slug')->reverse()->implode('/');

            return $ancestorsPath . '/' . $this->slug;
        }

        return $this->slug;
    }

    /**
     * Scope a query to only include published pages.
     */
    public function scopePublished(Builder $query): void
    {
        $query->where('published', true);
    }

    public function category(): ?BelongsTo
    {
        if ($this->categoryModel) {
            return $this->belongsTo($this->categoryModel)->with('ancestorsAndSelf');
        }
        return null;
    }

    public function ancestors()
    {
        return $this->category->ancestorsAndSelf ?? collect();
    }
}

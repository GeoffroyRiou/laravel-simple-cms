<?php

declare(strict_types=1);

namespace App\Models;

use App\Services\TranslatableJsonFieldCleaner;
use App\Traits\HasSeo;
use App\Traits\Menuable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Spatie\Translatable\HasTranslations;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

/**
 * @property int $id
 * @property string $title Translatable
 * @property string $excerpt
 * @property string $slug
 * @property string $url_path
 * @property bool $published
 * @property array $page_blocks Translatable
 * @property string $model_path
 * @property int|null $parent_id
 * @property int|null $category_id
 * @property string|null $categoryModel
 * @property string|null $illustration
 * @property bool $is_home
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Content[] $children
 * @property-read \App\Models\Content|null $parent
 * @property-read mixed $category
 * @property-read \Illuminate\Support\Collection $ancestors
 */
abstract class Content extends Model
{
    use HasRecursiveRelationships, HasSeo, HasTranslations, Menuable;

    public $table = 'contents';

    public string $routeName = 'cms.content';

    public string $viewName = 'components.pages.default-page';

    public ?string $categoryModel = null;

    protected $fillable = [
        'title',
        'excerpt',
        'slug',
        'url_path',
        'published',
        'page_blocks',
        'custom_fields',
        'model_path',
        'parent_id',
        'category_id',
        'illustration',
        'is_home',
    ];

    protected $casts = [
        'page_blocks' => 'array',
        'custom_fields' => 'array',
    ];

    protected $translatable = [
        'title',
        'page_blocks',
        'custom_fields',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('model_path', function (Builder $builder): void {
            $builder->where('model_path', static::class);
        });

        static::creating(function (Content $model): void {
            $model->model_path = static::class;
            $model->url_path = $model->getUrlPath();
        });

        static::updating(function (Content $model): void {
            $model->model_path = static::class;
            $model->url_path = $model->getUrlPath();
        });
    }

    public function pageBlocks(): Attribute
    {
        $cleaner = new TranslatableJsonFieldCleaner;

        return Attribute::make(
            get: function (mixed $value) use ($cleaner) {
                return is_array($value) ? $cleaner->clean($value) : $value;
            },
        );
    }

    /**
     * Get the custom field value if exists
     */
    public function field(string $key): mixed
    {
        $fields = $this->custom_fields ?? [];
        if (array_key_exists($key, $fields)) {
            return $this->custom_fields[$key];
        }

        return null;
    }

    /**
     * Get the URL for the page.
     */
    public function getUrl(): string
    {
        return LaravelLocalization::localizeUrl($this->url_path ?? '');
    }

    /**
     * Get the URL path for the page.
     */
    public function getUrlPath(bool $includeSelf = true): string
    {

        if ($this->is_home) {
            return '/';
        }

        if (! empty($this->parent_id)) {
            $method = $includeSelf ? 'ancestorsAndSelf' : 'ancestors';

            return $this->$method()->pluck('slug')->reverse()->implode('/');
        }

        if (! empty($this->category_id)) {
            $ancestorsPath = $this->ancestors()->pluck('slug')->reverse()->implode('/');

            return $ancestorsPath.'/'.$this->slug;
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

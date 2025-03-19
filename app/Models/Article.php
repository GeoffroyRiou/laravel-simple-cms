<?php

namespace App\Models;

use App\Traits\IsCmsModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    use IsCmsModel;

    protected $fillable = [
        'illustration',
        'category_id',
    ];

    protected $translatable = [];

    public function getViewName(): string
    {
        return 'simple-cms.articles.single-article';
    }

    public function getUrlPath(): string
    {
        return $this->ancestors()
            ->pluck('slug')
            ->reverse()
            ->push($this->slug)
            ->implode('/');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class)->with('ancestorsAndSelf');
    }

    public function ancestors()
    {
        return $this->category->ancestorsAndSelf ?? collect();
    }
}

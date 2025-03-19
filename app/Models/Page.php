<?php

namespace App\Models;

use App\Traits\IsCmsModel;
use Illuminate\Database\Eloquent\Model;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class Page extends Model
{
    use IsCmsModel, HasRecursiveRelationships;

    protected $fillable = [
        'parent_id',
    ];

    protected $translatable = [];

    public function getUrlPath(bool $includeSelf = true): string
    {
        $method = $includeSelf ? 'ancestorsAndSelf' : 'ancestors';

        return $this->$method()->pluck('slug')->reverse()->implode('/');
    }

    public function getViewName(): string
    {
        return 'simple-cms.pages.single-page';
    }
}

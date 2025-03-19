<?php

namespace App\Models;

use App\Traits\IsCmsModel;
use Illuminate\Database\Eloquent\Model;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class Category extends Model
{
    use IsCmsModel, HasRecursiveRelationships;

    protected $fillable = [
        'parent_id',
    ];

    protected $translatable = [];

    public function getUrlPath(bool $includeSelf = true): string
    {
        if(!empty($this->parent_id) ) {
            $method = $includeSelf ? 'ancestorsAndSelf' : 'ancestors';
            return $this->$method()->pluck('slug')->reverse()->implode('/');
        }
        
        return $this->slug;
    }

    public function getViewName(): string
    {
        return 'simple-cms.categories.single-category';
    }
}

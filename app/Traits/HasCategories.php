<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasCategories
{
    
    /**
     * Handle categories relations
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(
            related : $this->categoryModel,
            table: 'content_category',
            foreignPivotKey: 'content_id',
            relatedPivotKey: 'category_id',
        );
    }
}

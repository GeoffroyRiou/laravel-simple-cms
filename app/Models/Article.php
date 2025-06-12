<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasCategories;

class Article extends Content
{
    use HasCategories;
    
    public ?string $categoryModel = ArticleCategory::class;
}

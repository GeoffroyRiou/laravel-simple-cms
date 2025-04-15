<?php

declare(strict_types=1);

namespace App\Models;

class Article extends Content
{
    public ?string $categoryModel = ArticleCategory::class;
}

<?php

namespace App\Models;

class Article extends Content {
    
    public string $categoryModel = ArticleCategory::class;
}

<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Filament\Resources\ArticleResource;
use App\Filament\Resources\ContentResource\Pages\CreateContent;

class CreateArticle extends CreateContent
{    
    protected static string $resource = ArticleResource::class;
}

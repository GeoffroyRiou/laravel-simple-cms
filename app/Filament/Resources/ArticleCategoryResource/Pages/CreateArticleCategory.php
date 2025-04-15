<?php

declare(strict_types=1);

namespace App\Filament\Resources\ArticleCategoryResource\Pages;

use App\Filament\Resources\ArticleCategoryResource;
use App\Filament\Resources\ContentResource\Pages\CreateContent;

class CreateArticleCategory extends CreateContent
{
    protected static string $resource = ArticleCategoryResource::class;
}

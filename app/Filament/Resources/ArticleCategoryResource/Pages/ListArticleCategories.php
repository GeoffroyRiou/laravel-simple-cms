<?php

declare(strict_types=1);

namespace App\Filament\Resources\ArticleCategoryResource\Pages;

use App\Filament\Resources\ArticleCategoryResource;
use App\Filament\Resources\ContentResource\Pages\ListContents;
use Filament\Actions;

class ListArticleCategories extends ListContents
{
    protected static string $resource = ArticleCategoryResource::class;
}

<?php

declare(strict_types=1);

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Filament\Resources\ArticleResource;
use App\Filament\Resources\ContentResource\Pages\ListContents;

class ListArticles extends ListContents
{
    protected static string $resource = ArticleResource::class;
}

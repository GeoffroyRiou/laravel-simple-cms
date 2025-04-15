<?php

declare(strict_types=1);

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Filament\Resources\ArticleResource;
use App\Filament\Resources\ContentResource\Pages\EditContent;

class EditArticle extends EditContent
{
    protected static string $resource = ArticleResource::class;
}

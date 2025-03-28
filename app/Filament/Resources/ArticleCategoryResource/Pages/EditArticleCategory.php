<?php

namespace App\Filament\Resources\ArticleCategoryResource\Pages;

use App\Filament\Resources\ArticleCategoryResource;
use App\Filament\Resources\ContentResource\Pages\EditContent;
use Filament\Resources\Pages\EditRecord;

class EditArticleCategory extends EditContent
{
    protected static string $resource = ArticleCategoryResource::class;
}

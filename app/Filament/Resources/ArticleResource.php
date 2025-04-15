<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Models\Article;

class ArticleResource extends ContentResource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationLabel = 'Articles';

    protected static ?string $navigationGroup = 'Actualités';

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static bool $shouldRegisterNavigation = true;

    public static bool $hasParent = false;

    public static bool $hasExcerpt = true;

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}

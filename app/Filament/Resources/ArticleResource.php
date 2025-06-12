<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Models\Article;
use Filament\Forms\Components\TextInput;

class ArticleResource extends ContentResource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationLabel = 'Articles';

    protected static ?string $navigationGroup = 'Actualités';

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static bool $shouldRegisterNavigation = true;

    public static bool $hasParent = true;

    public static bool $hasSort = false;

    public static bool $hasCategories = true;

    public static bool $hasExcerpt = true;

    protected static function getCustomFields(): array
    {
        return [
            TextInput::make('custom_fields.author')
                ->label('Author')
                ->required()
                ->maxLength(255)
                ->placeholder('Enter the author\'s name'),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}

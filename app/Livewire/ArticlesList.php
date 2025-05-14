<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Article;
use App\Models\ArticleCategory;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class ArticlesList extends Component
{
    use WithoutUrlPagination, WithPagination;

    public ?string $categoryId = '0';

    public int $perPage = 0;

    public function mount(?int $perPage = 6): void
    {
        $this->perPage = $perPage;
    }

    public function render()
    {
        $articles = Article::when($this->categoryId, function ($query) {
            $query->where('category_id', $this->categoryId);
        })->orderBy('created_at', 'desc')->simplePaginate($this->perPage);

        return view('livewire.articles-list', [
            'articles' => $articles,
            'categories' => ArticleCategory::all(),
        ]);
    }
}

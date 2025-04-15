<?php

namespace App\View\Components;

use App\Models\Content;
use App\Services\LinksService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PageBuilder extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(LinksService $linksService, private readonly Content $model)
    {
        $this->model->page_blocks = $linksService->hydrateLinksFromPageBlocks($this->model->page_blocks ?: []);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.page-builder.page-builder', [
            'blocks' => $this->model->page_blocks ?: [],
        ]);
    }
}

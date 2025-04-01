<?php

namespace App\View\Components;

use Closure;
use App\Models\Menu as MenuModel;
use App\Services\LinksService;
use App\Services\MenuService;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Menu extends Component
{

    private ?MenuModel $menu;

    /**
     * Create a new component instance.
     */
    public function __construct(private MenuService $menuService, private LinksService $linksService, int $menuId)
    {
        $this->menu = $this->menuService->getMenuFromId($menuId);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        if (!$this->menu) {
            return '';
        }

        return view('components.menu', [
            'title' => $this->menu->title,
            'items' => $this->linksService->hydrateLinksFromPageBlocks($this->menu->items)
        ]);
    }
}

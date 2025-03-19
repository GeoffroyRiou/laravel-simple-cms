<?php

namespace App\View\Components\SimpleCms;

use Closure;
use App\Models\Menu as MenuModel;
use App\Services\MenuService;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MainMenu extends Component
{

    private ?MenuModel $menu;

    /**
     * Create a new component instance.
     */
    public function __construct(private MenuService $menuService, int $menuId)
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

        return view('simple-cms::components.main-menu.main-menu', [
            'title' => $this->menu->title,
            'items' => $this->menuService->hydrateMenu($this->menu->items)
        ]);
    }
}

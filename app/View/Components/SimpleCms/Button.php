<?php

declare(strict_types=1);

namespace App\View\Components;

use App\Services\MenuService;
use Illuminate\View\Component;
use Illuminate\View\View;

class Button extends Component
{
    private array $data = [];
    public function __construct(private MenuService $menuService, ?array $data) {

        if(!$data) {
            return;
        }

        $this->data = $this->menuService->hydrateMenu([$data] , false)[0] ?? [];
    }

    public function render(): View{
        return view('components.button', [
            'data' => $this->data ?? [],
        ]);
    }
}

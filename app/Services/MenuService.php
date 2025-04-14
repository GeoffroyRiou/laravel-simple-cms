<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Menu;
use App\Traits\Menuable;

class MenuService
{
    protected array $modelPaths;

    public function __construct(protected ReflectionService $reflectionService)
    {
        $defaultPaths = config('simple-cms.model_paths', []);
        $this->modelPaths = array_merge($defaultPaths, [__DIR__.'/../Models']);
    }

    /**
     * Get all models that implement the Menuable interface
     */
    public function getMenuableModels(): array
    {
        $modelClasses = $this->reflectionService->getModelClassesFromPaths($this->modelPaths);
        $menuableModels = [];

        foreach ($modelClasses as $modelClass) {
            if (
                $this->reflectionService->isClassInstantiable($modelClass) &&
                $this->reflectionService->usesTrait($modelClass, Menuable::class)
            ) {
                $menuableModels = array_merge(
                    $menuableModels,
                    $this->getMenuableItems($modelClass),
                );
            }
        }

        return $menuableModels;
    }

    /**
     * Get menuable items from a class (models instances)
     */
    protected function getMenuableItems(string $modelClasse): array
    {
        return $modelClasse::all()->map(function ($item) use ($modelClasse): array {
            return [
                'key' => $modelClasse.':'.$item->id,
                'value' => $item->{$modelClasse::getLabelKey()},
            ];
        })->pluck('value', 'key')->toArray();
    }

    /**
     * Get menu from id
     */
    public function getMenuFromId(int $menuId): ?Menu
    {
        return Menu::find($menuId);
    }
}

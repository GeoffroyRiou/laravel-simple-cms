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

    public function getMenuablesSelectOptionsData(?string $locale = null): array
    {
        $menuablesModels = $this->getMenuablesModels();

        $options = [];

        foreach ($menuablesModels as $model) {
            $options = [
                ...$options,
                ...$this->getMenuablesDataFromClassName($model, $locale),
            ];
        }

        return $options;
    }

    /**
     * Get all models that implement the Menuable interface
     */
    public function getMenuablesModels(): array
    {
        $modelClasses = $this->reflectionService->getModelClassesFromPaths($this->modelPaths);
        $menuablesModels = [];

        foreach ($modelClasses as $modelClass) {
            if (
                $this->reflectionService->isClassInstantiable($modelClass) &&
                $this->reflectionService->usesTrait($modelClass, Menuable::class)
            ) {
                $menuablesModels[] = $modelClass;
            }
        }

        return $menuablesModels;
    }

    /**
     * Get menuable items from a class (models instances)
     */
    protected function getMenuablesDataFromClassName(string $modelClass, ?string $locale): array
    {

        if (! $locale) {
            $locale = config('app.locale');
        }

        return $modelClass::all()->map(function ($item) use ($modelClass, $locale): array {
            $label = $item->getTranslation($modelClass::getLabelKey(), $locale) ?: $item->{$modelClass::getLabelKey()};

            return [
                'key' => $modelClass.':'.$item->id,
                'value' => $label,
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

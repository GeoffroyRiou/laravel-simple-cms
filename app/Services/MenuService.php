<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Menu;
use App\Traits\Menuable;
use App\Traits\IsCmsModel;

class MenuService
{
    protected array $modelPaths;

    public function __construct(protected ReflectionService $reflectionService)
    {
        $defaultPaths = config('simple-cms.model_paths', []);
        $this->modelPaths = array_merge($defaultPaths, [__DIR__ . '/../Models']);
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
                $this->reflectionService->usesTrait($modelClass, Menuable::class) ||
                $this->reflectionService->usesTrait($modelClass, IsCmsModel::class)
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
        return $modelClasse::all()->map(function ($item) use ($modelClasse) {
            return [
                'key' => $modelClasse . ':' . $item->id,
                'value' => $item->{$modelClasse::getLabelKey()},
            ];
        })->pluck('value', 'key')->toArray();
    }

    /**
     * Get menu from id
     * @param int $menuId
     * @return Menu|null
     */
    public function getMenuFromId(int $menuId): Menu | null
    {
        return Menu::find($menuId);
    }

    /**
     * Hydrate menu generating all urls from items
     * @param array $items
     * @return array
     */
    public function hydrateMenu(array $items, bool $includeChildren = true): array
    {
        $result = [];
        $pageIds = [];

        // First pass: collect all page IDs grouped by model
        foreach ($items as $item) {
            if ($item['type'] === 'page') {
                $pageDatas = explode(':', $item['page']);
                $pageModel = $pageDatas[0];
                $pageId = $pageDatas[1];

                // Initialize the array for the model if it doesn't exist
                if (!isset($pageIds[$pageModel])) {
                    $pageIds[$pageModel] = [];
                }
                $pageIds[$pageModel][] = $pageId; // Collecting IDs for each model
            }
        }

        // Fetch all pages in one query for each model
        $pages = [];
        foreach ($pageIds as $model => $ids) {
            $modelClass = $model; // Assuming the model name is the class name
            if (class_exists($modelClass)) {
                $pages[$model] = $modelClass::whereIn('id', $ids)->get()->keyBy('id');
            }
        }

        // Second pass: hydrate menu with URLs
        foreach ($items as $item) {
            $url = $item['url'] ?? '';

            // Check if the type is 'page' and extract the classpath:id
            if ($item['type'] === 'page') {
                $pageDatas = explode(':', $item['page']);
                $pageModel = $pageDatas[0];
                $pageId = $pageDatas[1];

                // Use the pre-fetched pages to get the URL
                $page = $pages[$pageModel]->get($pageId) ?? null;
                $url = $page ? $page->getUrl() : '#';
            }

            // Default data
            $currentItem = array_merge($item, [
                'url' => $url,
            ]);

            if($includeChildren && !empty($item['children'])){
                $currentItem['children'] = [];

                // Recursively call this function
                $currentItem['children'] = $this->hydrateMenu($item['children']);
            }

            // Add the item to the result
            $result[] = $currentItem;
        }

        return $result;
    }

    protected function getPageUrl(string $model, string $id): string
    {
        // Implement logic to retrieve the URL for the page based on the model and ID
        // For example, you might have a Page model with a method to get the URL
        $page = $model::find($id);
        return $page ? $page->getUrl() : '#';
    }
}

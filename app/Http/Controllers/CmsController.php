<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Page;
use App\Services\ReflectionService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\View;

class CmsController extends Controller
{
    protected array $modelPaths;

    public function __construct(private readonly ReflectionService $reflectionService)
    {
        $defaultPaths = config('simple-cms.model_paths', []);
        $this->modelPaths = array_merge($defaultPaths, [app_path('Models')]);
    }

    public function content(string $path): View
    {
        $model = $this->getModel($this->getSlug($path));

        if (! $model) {
            abort(404);
        }

        return $this->render($model, $model->viewName ?? null);
    }

    public function home(): View
    {
        $model = Page::where('is_home', true)->first();
        if (! $model) {
            abort(404);
        }

        return $this->render($model, config('simple-cms.home_view_name'));
    }

    private function render(Model $model, string $viewName): View
    {
        return view($viewName ?: null, compact('model'));
    }

    /**
     * Get the slug from the path.
     */
    private function getSlug(string $path): string
    {
        $parts = explode('/', $path);

        return array_pop($parts);
    }

    /**
     * Tries to retrieve a model based on the slug.
     * Only for models that implement the IsCmsModel trait
     */
    protected function getModel(string $slug): ?Model
    {
        $currentLocale = app()->currentLocale();

        $modelClasses = $this->reflectionService->getModelClassesFromPaths(
            $this->modelPaths,
        );

        foreach ($modelClasses as $modelClass) {

            if (
                ! (
                    $this->reflectionService->isClassInstantiable($modelClass) &&
                    $this->reflectionService->hasParentOfType($modelClass, Content::class)
                )
            ) {
                continue;
            }

            $query = $modelClass::published()->where('slug', $slug);

            if ($query->exists()) {
                return $query->first();
            }
        }

        return null;
    }
}

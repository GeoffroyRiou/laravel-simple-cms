<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ReflectionService;
use Illuminate\View\View;
use App\Traits\IsCmsModel;
use Illuminate\Database\Eloquent\Model;

class CmsController extends Controller
{
    protected array $modelPaths;

    public function __construct(private ReflectionService $reflectionService)
    {
        $defaultPaths = config('simple-cms.model_paths', []);
        $this->modelPaths = array_merge($defaultPaths, [app_path('Models')]);
    }

    public function __invoke(string $path): View
    {
        $model = $this->getModel($this->getSlug($path));

        if (!$model) {
            abort(404);
        }

        return view($model->getViewName() ?? null, compact('model'));
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
     * @param string $slug
     * @return Model|null
     */
    protected function getModel(string $slug): ?Model
    {
        $currentLocale = app()->currentLocale();

        $modelClasses = $this->reflectionService->getModelClassesFromPaths(
            $this->modelPaths,
        );

        foreach ($modelClasses as $modelClass) {

            if (!$this->reflectionService->usesTrait($modelClass, IsCmsModel::class)) {
                continue;
            }


            $query = $modelClass::published()->where("slug->$currentLocale", $slug);

            if ($query->exists()) {
                return $query->first();
            }
        }

        return null;
    }
}

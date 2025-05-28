<?php

namespace App\Services;

use Illuminate\View\View;

class SitemapService
{
    /** @property array<int,string> $modelsToUse */
    private array $modelsToUse = [];

    /**
     * Create a new class instance.
     */
    public function __construct(MenuService $menuService)
    {
        $this->modelsToUse = $menuService->getMenuablesModels();
    }

    /**
     * Fetch all model instances.
     */
    private function fetchModelInstances(): array
    {
        $models = [];

        foreach ($this->modelsToUse as $modelClass) {

            $query = $modelClass::query();

            if (method_exists($modelClass, 'published')) {
                $query->published();
            }

            if (property_exists($modelClass, 'path')) {
                $query->orderby('path');
            }

            $modelInstances = $query->get();

            foreach ($modelInstances as $instance) {
                $models[] = $instance;
            }
        }

        return $models;
    }

    /**
     * Generate the sitemap XML content.
     */
    public function generateXMLSitemap(): string
    {
        $models = $this->fetchModelInstances();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

        foreach ($models as $model) {

            $xml .= '<url>'."\n";
            $xml .= '<loc>'.url($model->getUrl() ?? '').'</loc>'."\n";
            $xml .= '<changefreq>weekly</changefreq>'."\n";
            $xml .= '<priority>0.8</priority>'."\n";
            $xml .= '</url>'."\n";
        }

        $xml .= '</urlset>';

        return $xml;
    }

    public function generateHTMLSitemap(): View
    {
        return view('components.sitemap', [
            'models' => $this->fetchModelInstances(),
        ]);
    }
}

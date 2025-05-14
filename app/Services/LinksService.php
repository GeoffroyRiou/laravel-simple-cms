<?php

declare(strict_types=1);

namespace App\Services;

class LinksService
{
    public function hydrateLinksFromPageBlocks(array $pageBlocksData): array
    {
        $pagesIdsByModel = $this->getPagesIdsByModelFromPageBlockData($pageBlocksData);

        $pagesByModel = $this->getPagesUrlByModelFromIdsByModel($pagesIdsByModel);

        return $this->hydrateLinksFromPageBlock($pageBlocksData, $pagesByModel);
    }

    private function getPagesIdsByModelFromPageBlockData(array $item, array $pagesIdsByModel = [])
    {
        if (! is_array($item)) {
            return $pagesIdsByModel;
        }

        if (! empty($item['type']) && $item['type'] == 'page') {
            $pageDatas = explode(':', (string) $item['page']);
            $pageModel = $pageDatas[0];
            $pageId = $pageDatas[1];

            if (! isset($pagesIdsByModel[$pageModel])) {
                $pagesIdsByModel[$pageModel] = [];
            }

            if (! in_array($pageId, $pagesIdsByModel[$pageModel])) {
                $pagesIdsByModel[$pageModel][] = $pageId;
            }
        }

        foreach ($item as $key => $value) {

            if (is_array($value)) {
                $pagesIdsByModel = $this->getPagesIdsByModelFromPageBlockData($value, $pagesIdsByModel);
            }
        }

        return $pagesIdsByModel;
    }

    /**
     * @param  array<string,array<int>>  $pagesIdsByModel
     */
    private function getPagesUrlByModelFromIdsByModel(array $pagesIdsByModel): array
    {

        $pagesByModel = [];

        foreach ($pagesIdsByModel as $model => $ids) {
            $pages = $model::whereIn('id', $ids)->get();

            foreach ($pages as $page) {
                $pagesByModel[$model][$page->id] = $page->getUrl();
            }
        }

        return $pagesByModel;
    }

    private function hydrateLinksFromPageBlock(array $item, array $pagesUrl): array
    {

        if (! is_array($item)) {
            return $item;
        }

        if (! empty($item['type']) && $item['type'] == 'page') {
            $pageDatas = explode(':', (string) $item['page']);
            $pageModel = $pageDatas[0];
            $pageId = $pageDatas[1];

            if (! empty($pagesUrl[$pageModel][$pageId])) {
                $item['url'] = $pagesUrl[$pageModel][$pageId];
            }
        }

        foreach ($item as $key => $value) {
            if (is_array($value)) {
                $item[$key] = $this->hydrateLinksFromPageBlock($value, $pagesUrl);
            }
        }

        return $item;
    }
}

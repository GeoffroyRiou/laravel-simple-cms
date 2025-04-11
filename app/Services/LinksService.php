<?php

namespace App\Services;

class LinksService{

    public function hydrateLinksFromPageBlocks(array $pageBlocksData): array{

        $pagesIdsByModel = $this->getPagesIdsByModelFromPageBlockData($pageBlocksData);

        $pagesByModel = $this->getPagesUrlByModelFromIdsByModel($pagesIdsByModel);

        $hydratedPageBlocksData = $this->hydrateLinksFromPageBlock($pageBlocksData, $pagesByModel);

        return $hydratedPageBlocksData;
    }

    private function getPagesIdsByModelFromPageBlockData(array $data, array $pagesIdsByModel = []){

        foreach($data as $item){

            if(!is_array($item)){
                continue;
            }

            if(!empty($item['type']) && $item['type'] == 'page'){
                $pageDatas = explode(':', $item['page']);
                $pageModel = $pageDatas[0];
                $pageId = $pageDatas[1];

                if(!isset($pagesIdsByModel[$pageModel])){
                    $pagesIdsByModel[$pageModel] = [];
                }

                if(!in_array($pageId, $pagesIdsByModel[$pageModel])){
                    $pagesIdsByModel[$pageModel][] = $pageId;
                }

                continue;
            }

            $pagesIdsByModel = $this->getPagesIdsByModelFromPageBlockData($item, $pagesIdsByModel);
        }
        return $pagesIdsByModel;
    }

    private function getPagesUrlByModelFromIdsByModel(array $pagesIdsByModel): array{

        $pagesByModel = [];

        foreach($pagesIdsByModel as $model => $ids){
            $pages = $model::whereIn('id', $ids)->get();

            foreach($pages as $page){
                $pagesByModel[$model][$page->id] = $page->getUrl();
            }
        }

        return $pagesByModel;
    }

    private function hydrateLinksFromPageBlock(array $data, $pagesUrl): array{

        foreach($data as $index => $item){

            if(!is_array($item)){
                continue;
            }

            if(!empty($item['type']) && $item['type'] == 'page'){
                $pageDatas = explode(':', $item['page']);
                $pageModel = $pageDatas[0];
                $pageId = $pageDatas[1];

                if(!empty($pagesUrl[$pageModel][$pageId]))
                    $data[$index]['url'] = $pagesUrl[$pageModel][$pageId];

                continue;
            }

            $data[$index] = $this->hydrateLinksFromPageBlock($item, $pagesUrl);
            
        }

        return $data;
    }
}
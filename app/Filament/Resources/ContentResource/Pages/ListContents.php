<?php

declare(strict_types=1);

namespace App\Filament\Resources\ContentResource\Pages;

use App\Models\Content;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class ListContents extends ListRecords
{
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTableQuery(): Builder
    {

        $resource = static::getResource();
        $query = $resource::getEloquentQuery();

        if ($resource::$hasSort) {
            return $query;
        }

        $nestedArray = self::getNestedArray();

        // Vérifiez le type de base de données
        if (DB::getDriverName() === 'sqlite') {
            // Solution pour SQLite
            $orderRaw = "CASE id ";
            foreach ($nestedArray as $index => $id) {
                $orderRaw .= sprintf("WHEN %d THEN %d ", $id, $index);
            }
            $orderRaw .= "END";

            $query->orderByRaw($orderRaw);
        } else {
            // Solution pour MySQL
            $query->orderByRaw(sprintf("FIELD(id, %s)", implode(',', $nestedArray)));
        }

        return $query;
    }


    public static function getNestedArray($parent_id = 0, &$ids = null): array
    {
        static $records = null;
        if ($ids === null) {
            $ids = [];
        }
        if ($records === null) {
            $records = self::getResource()::getModel()::get(['id', 'parent_id', 'order'])
                ->groupBy('parent_id')
                ->toArray();
        }
        if (isset($records[""])) {
            $records[0] = $records[""];
            unset($records[""]);
        }
        if (isset($records[$parent_id]) && count($records[$parent_id])) {
            usort($records[$parent_id], function ($a, $b) {
                return ($a['order'] ?? 0) <=> ($b['order'] ?? 0);
            });
            foreach ($records[$parent_id] as $_item) {
                $ids[] = $_item['id'];
                if (isset($records[$_item['id']]) && is_array($records[$_item['id']]) && count($records[$_item['id']])) {
                    self::getNestedArray($_item['id'], $ids);
                }
            }
        }
        return $ids;
    }

    public static function getNestedPrefix($parent_id, string $model, $prefix = ''): string
    {
        static $parents = null;
        if ($parents == null)
            $parents = $model::getModel()::all()->pluck('parent_id', 'id');
        if ($parent_id == 0) return '';
        if (isset($parents[$parent_id]) && $parents[$parent_id]) {
            $prefix .= self::getNestedPrefix($parents[$parent_id], $model, $prefix . '&nbsp;&nbsp;');
        }

        return $prefix;
    }
}

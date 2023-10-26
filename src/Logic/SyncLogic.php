<?php

namespace Rembon\SyncCollection\Logic;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use LogicException;

class SyncLogic
{
    /**
     * Process the Between Old and New Singular Collection With Key
     *
     * @param Collection|EloquentCollection|Model $old_collection
     * @param Collection|EloquentCollection|Model $new_collection
     * @param array $key
     *
     * @return Collection|array
     */
    public function withSingleBetween(
        Collection|EloquentCollection|Model $old_collection,
        Collection|EloquentCollection|Model $new_collection,
        array $key = []
    ) {
        foreach ($this->uniqueArrayKey($key) as $index) {
            if (!array_key_exists($index, $old_collection->toArray())) {
                throw new LogicException("Key To Protect Not Exists Inside Old Collection");
            }

            $new_collection->prepend(null, $index);
        }

        if ($old_collection instanceof Model || $new_collection instanceof Model) {
            $old_collection = collect($old_collection->toArray());
            $new_collection = collect($new_collection->toArray());
        }

        return $old_collection->map(function ($item, $key) use ($new_collection) {
            return $new_collection[$key] ?? $item;
        });
    }

    /**
     * Process the Between Old and New Many Collection With Key
     *
     * @param Collection $old_collection
     * @param Collection $new_collection
     * @param string $unique_key
     * @param array $columns_to_merge
     *
     * @return Collection|array
     */
    public function withManyBetween(
        Collection $old_collection,
        Collection $new_collection,
        string $unique_key = "",
        array $columns_to_merge = []
    ) {
        $merged_data = $old_collection->concat($new_collection);
        // dd($merged_data);
        $synced_data = $merged_data->groupBy($unique_key)->map(function ($items, $index) use ($columns_to_merge) {
            return $items->reduce(function ($carry, $item) use ($columns_to_merge) {
                $merged_item = ['id' => $carry['id'] ?? $item['id'] ?? null];
                foreach ($columns_to_merge as $column) {
                    $merged_item[$column] = max($carry[$column] ?? 0, $item[$column]);
                }

                return $merged_item;
            }, []);
        })->values();

        return $synced_data;
    }

    /**
     * Process the Unique Key Between Both Collection Data
     *
     * @param array $key
     * @return array
     */
    public function uniqueArrayKey(array $key)
    {
        return array_unique($key);
    }
}

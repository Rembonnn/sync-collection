<?php

namespace Rembon\SyncCollection\Logic;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use LogicException;

class SyncLogic
{
    /**
     * Apendables data getter
     *
     * @var array
     */
    protected $appends = [];

    /**
     * Curents data getter
     *
     * @var array
     */
    protected $currents = [];

    /**
     * Process the Between Old and New Singular Collection With Key
     *
     * @param Collection|Model $old_collection
     * @param Collection|Model $new_collection
     * @param array $key
     *
     * @return Collection|array
     */
    public function withSingleBetween(
        Collection|Model $old_collection,
        Collection|Model $new_collection,
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
     * Process the Between Old and New Associative Collection With Key
     *
     * @param Collection|Model $old_collection
     * @param Collection|Model $new_collection
     * @param string $unique_key
     * @param array $columns_to_merge
     *
     * @return Collection|array
     */
    public function withAssociativeBetween(
        Collection|Model $old_collection,
        Collection|Model $new_collection,
        string $unique_key = ""
    ) {
        $merge_old_new_collection = $old_collection->concat($new_collection);
        $merge_old_new_collection->each(function ($item, $key) use ($unique_key) {
            in_array($unique_key, array_keys($item))
                ? array_push($this->currents, $item)
                : array_push($this->appends, $item);
        });

        $separate = $this->separateCollectionWithUnique(collect($this->currents), $unique_key);

        return collect([
            'currents' => $separate['currents'],
            'appends' => collect($this->appends),
            'olds' => $separate['removes'],
            'updated' => $separate['updated'],
        ]);
    }

    /**
     * Separate Between use and unused Data Collection
     *
     * @param Collection|Model $collection
     * @param string $unique_key
     *
     * @return Collection
     */
    private function separateCollectionWithUnique(Collection|Model $collection, string $unique_key)
    {
        $results = collect([]);

        $get_duplicate = $collection->duplicates($unique_key);
        $get_duplicate->keys()->each(function ($index_value, $key) use ($collection, $results) {
            $results->push($collection[$index_value]);
        });

        $remove_old_with_new = $collection->filter(function ($item, $key) use ($results, $unique_key) {
            $last_item = array();
            foreach ($results as $key => $val) {
                array_push($last_item, $val);
            }
            return !in_array($item, $last_item);
        });

        $currents = $remove_old_with_new->splice($results->count());

        return collect([
            'currents' => $currents,
            'removes' => $remove_old_with_new,
            'updated' => $results
        ]);
    }

    /**
     * Process the Unique Key Between Both Collection Data
     *
     * @param array $key
     * @return array
     */
    private function uniqueArrayKey(array $key)
    {
        return array_unique($key);
    }
}

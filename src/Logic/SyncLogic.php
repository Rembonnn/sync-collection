<?php

namespace Rembon\SyncCollection\Logic;

use Illuminate\Support\Collection;
use LogicException;

class SyncLogic
{
    /**
     * Process the Between Old and New Collection With Key
     *
     * @param Collection $oldCollection
     * @param Collection $newCollection
     * @param array $key
     */
    public function withBetweenSingular(Collection $oldCollection, Collection $newCollection, array $key)
    {
        foreach($key as $index) {
            if (!array_key_exists($index, $oldCollection->toArray())) {
                throw new LogicException("Key To Protect Not Exists Inside Old Collection");
            }

            $newCollection->prepend(null, $index);
        }

        return $oldCollection->map(function ($item, $key) use ($newCollection) {
            return $newCollection[$key] ?? $item;
        });
    }

    /** */

    /**
     * Process the Old Collection Data
     *
     * @param Collection $collection
     * @param $callback
     * @return Collection
     */
    public function oldCollection(Collection $collection, $callback = null)
    {
        if (!is_null($callback)) {
            $callback($collection);

            return $collection;
        }

        return $collection;
    }

    /**
     * Process the New Collection Data
     *
     * @param Collection $collection
     * @param $callback
     * @return Collection
     */
    public function newCollection(Collection $collection, $callback = null)
    {
        if (!is_null($callback)) {
            $callback($collection);

            return $collection;
        }

        return $collection;
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

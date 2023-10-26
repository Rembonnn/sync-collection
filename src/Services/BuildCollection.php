<?php

namespace Rembon\SyncCollection\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class BuildCollection
{
    /**
     * Process the Building Collection Data
     *
     * @param Collection|Model $collection
     * @param $callback
     *
     * @return Collection
     */
    public static function set(Collection|Model $collection, $callback = null)
    {
        if ($collection instanceOf Model) {
            $collection = collect($collection->toArray());
        }

        if (!is_null($callback)) {
            return $callback($collection);
        }

        return $collection;
    }
}

<?php

namespace Rembon\SyncCollection\Logic;

use Illuminate\Support\Collection;

class SyncLogic
{
    /**
     * Get the Old Collection Data
     *
     * @var Collection
     */
    protected $oldCollectionData;

    /**
     * Get the New Collection Data
     *
     * @var Collection
     */
    protected $newCollectionData;

    /**
     * Instantiate the Constructor of Sync Logic Class
     *
     * @param Collection $oldCollectionData
     * @param Collection $newCollectionData
     * @return void
     */
    public function __construct(Collection $oldCollectionData, Collection $newCollectionData)
    {
        $this->oldCollectionData = $oldCollectionData;
        $this->newCollectionData = $newCollectionData;
    }

    /**
     * Process the Old Collection Data
     *
     * @param Collection $collection
     * @param $callback
     * @return Collection
     */
    private function oldCollection(Collection $collection, $callback = null)
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
    private function newCollection(Collection $collection, $callback = null)
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
    private function uniqueArrayKey(array $key)
    {
        return array_unique($key);
    }
}

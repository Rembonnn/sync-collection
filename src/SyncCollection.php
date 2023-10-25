<?php

namespace Rembon\SyncCollection;

use Illuminate\Support\Facades\Facade;

class SyncCollection extends Facade
{
    /**
     * Build Acessor For Sync Collection
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'sync-collection';
    }
}

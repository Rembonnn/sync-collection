<?php

namespace Rembon\SyncCollection;

use Illuminate\Support\ServiceProvider;
use Rembon\SyncCollection\Logic\SyncLogic;

class SyncCollectionServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('sync_collection', function () {
            return new SyncLogic();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

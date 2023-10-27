# Sync Laravel Collection Data
Sebuah Package untuk Sinkronisasi Data Collection.

## Features
- Sync Untuk Dua Data Collection (Singular)
- Sync Untuk Dua Data Collection (Multi Dimensi)

## Installation
Installasi Via Composer
```bash
composer require rembon/sync-collection
```

Buka file Config/app.php, Lalu Pastekan syntax berikut pada bagian Autoload Service Providers
```php
'providers' => ServiceProvider::defaultProviders()->merge([
    ...
    Rembon\SyncCollection\SyncCollectionServiceProvider::class,
    ...
])->toArray(),
```

## How to Use
Pastikan anda mengimport kedua class berikut
```php
use Rembon\SyncCollection\Services\BuildCollection;
use Rembon\SyncCollection\SyncCollection;
```

### Build Collection Services
Dipakai untuk manipulasi Collection dengan menggunakan nilai daripada Collection itu sendiri
```php
BuildCollection::set(Collection $collection, Builder $callback)
```

### Sync Singular Data Collection
Dipakai untuk Sinkronisasi Kedua Collection yang `singular`
```php
SyncCollection::withSingleBetween(Collection $old_collection, Collection $new_collection);
```

### Sync Multi Dimensional Data Collection
Dipakai untuk Sinkronisasi Kedua Collection yang `Multi Dimensional`
```php
SyncCollection::withMultiDimensionBetween(Collection $old_collection, Collection $new_collection, string $unique_key);
```

## Examples
Berikut adalah contoh penggunaan kasusnya.

### Build Collection Services
Untuk Build Collection dapat digunakan untuk penggunaan Advance, Berikut adalah Contoh Sederhana untuk proses mapping data Collection
```php
BuildCollection::set($oldData, function ($item) {
    return $item->map(function ($val, $key) {
        return $val['quantity'] > 20;
    });
})
```

## Credits
- [Rembon Karya Digital](https://github.com/rembonnn)
- [DayCod](https://github.com/dayCod)
- [See All Contributors](https://github.com/rembonnn/sync-collection/contributors)

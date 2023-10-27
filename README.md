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

## Usage Examples


## Credits
- [Rembon Karya Digital](https://github.com/rembonnn)
- [DayCod](https://github.com/dayCod)
- [See All Contributors](https://github.com/rembonnn/sync-collection/contributors)

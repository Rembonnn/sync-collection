# Sync Laravel Collection Data
Sebuah Package untuk Sinkronisasi Data Collection.

## Features
- Sync Untuk Dua Data Collection (Singular)
- Sync Untuk Dua Data Collection (Dua Dimensi / Asosiatif)

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
SyncCollection::withSingleBetween(Collection $old_collection, Collection $new_collection, array $unique_key_to_protect);
```

### Sync Associative Data Collection
Dipakai untuk Sinkronisasi Kedua Collection yang `associative`
```php
SyncCollection::withAssociativeBetween(Collection $old_collection, Collection $new_collection, string $unique_key);
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

Akan Menghasilkan Hasil Seperti berikut Ini:
```php
[
    0 => false,
    1 => false,
    2 => true
]
```

### Sync Singular Data Collection
Sinkronisasi Untuk Singular Data Collection
```php
// Data Lama Singular
$old_data = collect([
    'id' => 1,
    'name' => 'item 1',
    'quantity' => 10,
]);

// Data Baru Singular
$new_data = collect([
    'name' => 'New Item 1',
    'quantity' => 100,
]);

return SyncCollection::withSingleBetween($old_data, $new_data, ['id']);
```

Akan menghasilkan data seperti berikut ini:
```php
[
    "id" => 1,
    "name" => "New Item 1",
    "quantity" => 100
]
```

### Sync Associative Data Collection
Sinkronisasi Untuk Associative Data Collection
```php
// Data lama
$oldData = collect([
    ['id' => 1, 'name' => 'Item 1', 'quantity' => 10],
    ['id' => 2, 'name' => 'Item 2', 'quantity' => 20],
    ['id' => 3, 'name' => 'Item 3', 'quantity' => 30],
]);

// Data baru
$newData = collect([
    ['id' => 1, 'name' => 'New Item', 'quantity' => 15],
    ['name' => 'Another New Item', 'quantity' => 25],
    ['name' => 'Another New Items 2', 'quantity' => 250],
]);

return SyncCollection::withAssociativeBetween($oldData, $newData, 'id');
```

Berikut Adalah hasil daripada Sinkronisasi Associative Data Collection:
```php
[
    "currents" => [
        [
          "id" => 2, 
          "name" => "Item 2",
          "quantity" => 20
        ],
        [
          "id" => 3,
          "name" => "Item 3",
          "quantity" => 30
        ]
    ],
    "appends" => [
        [
           "name" => "Another New Item",
           "quantity" => 25
        ],
        [
           "name" => "Another New Items 2",
           "quantity" => 250
        ]
    ],
    "olds" => [
        [
           "id" => 1,
           "name" => "Item 1",
           "quantity" => 10
        ]
    ],
    "updated" => [
        [
           "id" => 1
           "name" => "New Item"
           "quantity" => 15
        ]
    ]
]
```
#### Notes
- `currents` data yang tidak ada perubahan baik sebelum atau sesudah ada request.
- `appends` data baru yang tidak ada dalam data sebelumnya.
- `olds` data lama yang sudah tidak terpakai.
- `updated` data baru yang menggantikan data lama yang sudah tidak terpakai.

## Credits
- [Rembon Karya Digital](https://github.com/rembonnn)
- [DayCod](https://github.com/dayCod)
- [See All Contributors](https://github.com/rembonnn/sync-collection/contributors)

## References
- [Laravel Collection Available Methods](https://laravel.com/docs/10.x/collections#available-methods)

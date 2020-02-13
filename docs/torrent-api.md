# Torrent API

### Retrieve all torrents

```php
/** @var \OwenVoke\Unit3d\Unit3d $unit3d */
$unit3d->torrents()->getAll();
````

## Retrieve a specific torrent by its id

```php
/** @var \OwenVoke\Unit3d\Unit3d $unit3d */
$unit3d->torrents()->get(123);
```

## Search for torrents using query filters

```php
/** @var \OwenVoke\Unit3d\Unit3d $unit3d */
$unit3d->torrents()->filter(1, ['name' => 'James Bond']);
```

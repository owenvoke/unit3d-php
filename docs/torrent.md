# Torrent API

[Back to the navigation](README.md)

Allows interacting with the Torrent API.

### Get a list of all torrents

```php
$response = $client->torrents()->all();
```

### Get details about a torrent

```php
$response = $client->torrents()->show(123);
```

### Get a filtered list of all torrents

```php
$response = $client->torrents()->filtered([
    'tmdb' => 12345,
]);
```

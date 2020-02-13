# Getting Started

> **Requires:** [PHP 7.4 or later](https://php.net/releases)

First, install UNIT3D PHP via the `Composer` package manager:

```bash
composer require owenvoke/unit3d
```

### Set up the UNIT3D instance

```php
use OwenVoke\Unit3d\Adapter\HttpAdapter;
use OwenVoke\Unit3d\Unit3d;

$adapter = new HttpAdapter('api-token');

$unit3d = new Unit3d($adapter, 'https://unit3d.site');
```

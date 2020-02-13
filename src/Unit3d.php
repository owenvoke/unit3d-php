<?php

declare(strict_types=1);

namespace OwenVoke\Unit3d;

use OwenVoke\Unit3d\Adapter\HttpAdapter;

final class Unit3d
{
    protected HttpAdapter $adapter;

    public function __construct(HttpAdapter $adapter)
    {
        $this->adapter = $adapter;
    }
}

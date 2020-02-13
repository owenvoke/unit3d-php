<?php

declare(strict_types=1);

namespace OwenVoke\Unit3d\Api;

use OwenVoke\Unit3d\Adapter\HttpAdapter;

abstract class AbstractApi
{
    protected HttpAdapter $adapter;

    protected string $endpoint;

    public function __construct(HttpAdapter $adapter, string $endpoint)
    {
        $this->adapter = $adapter;
        $this->endpoint = $endpoint;
    }
}

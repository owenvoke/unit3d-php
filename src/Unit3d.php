<?php

declare(strict_types=1);

namespace OwenVoke\Unit3d;

use OwenVoke\Unit3d\Adapter\HttpAdapter;
use OwenVoke\Unit3d\Api\Torrent;

class Unit3d
{
    protected HttpAdapter $adapter;
    private string $endpoint;

    public function __construct(HttpAdapter $adapter, string $endpoint)
    {
        $this->adapter = $adapter;
        $this->endpoint = $endpoint;
    }

    public function torrents(): Torrent
    {
        return new Torrent($this->adapter, $this->endpoint);
    }
}

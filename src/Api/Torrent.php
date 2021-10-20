<?php

declare(strict_types=1);

namespace OwenVoke\UNIT3D\Api;

class Torrent extends AbstractApi
{
    public function all(array $parameters = []): array
    {
        return $this->get('/torrents', $parameters);
    }

    public function show(int $id, array $parameters = []): array
    {
        return $this->get(sprintf('/torrents/%s', $id), $parameters);
    }

    public function filtered(array $parameters = []): array
    {
        return $this->get('/torrents/filter', $parameters);
    }
}

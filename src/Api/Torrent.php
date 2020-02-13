<?php

namespace OwenVoke\Unit3d\Api;

use OwenVoke\Unit3d\Entity\Torrent as TorrentEntity;

class Torrent extends AbstractApi
{
    public function getAll(?int $page = null): array
    {
        $query = http_build_query(['page' => $page ?? 1]);

        $response = $this->adapter->get(sprintf('%s/api/torrents?%s', $this->endpoint, $query));

        $data = json_decode($response);

        return array_map(static function ($torrent) {
            $meta = $torrent->attributes ?? [];
            $meta->id = (int) $torrent->id;

            return new TorrentEntity($meta);
        }, $data->data);
    }
}

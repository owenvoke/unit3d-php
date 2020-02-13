<?php

namespace OwenVoke\Unit3d\Api;

use OwenVoke\Unit3d\Entity\Torrent as TorrentEntity;
use stdClass;

class Torrent extends AbstractApi
{
    /**
     * @param  int|null  $page
     * @return array<int, TorrentEntity>
     */
    public function getAll(?int $page = null): array
    {
        $query = http_build_query(['page' => $page ?? 1]);

        $response = $this->adapter->get(sprintf('%s/api/torrents?%s', $this->endpoint, $query));

        $data = json_decode($response);

        return array_map(static function (stdClass $torrent): TorrentEntity {
            $meta = $torrent->attributes ?? [];
            $meta->id = (int) $torrent->id;

            return new TorrentEntity($meta);
        }, $data->data);
    }

    public function get(int $id): TorrentEntity
    {
        $response = $this->adapter->get(sprintf('%s/api/torrents/%s', $this->endpoint, $id));

        $data = json_decode($response);

        $meta = $data->attributes ?? [];
        $meta->id = (int) $data->id;

        return new TorrentEntity($meta);
    }

    /**
     * @param  int|null  $page
     * @param  array<string, string|int|bool>  $filters
     * @return array<int, TorrentEntity>
     */
    public function filter(?int $page = null, array $filters = []): array
    {
        $filters = $this->validateFilters($filters);

        $query = http_build_query(array_merge($filters, ['page' => $page ?? 1]));

        $response = $this->adapter->get(sprintf('%s/api/torrents/filter?%s', $this->endpoint, $query));

        $data = json_decode($response);

        return array_map(static function (stdClass $torrent): TorrentEntity {
            $meta = $torrent->attributes ?? [];
            $meta->id = (int) $torrent->id;

            return new TorrentEntity($meta);
        }, $data->data);
    }

    /**
     * @param  array<string, string|int|bool>  $filters
     * @return array<string, string|int|bool>
     */
    private function validateFilters(array $filters): array
    {
        $allowedKeys = [
            'name',
            'description',
            'uploader',
            'imdb',
            'tvdb',
            'tmdb',
            'mal',
            'igdb',
            'start_year',
            'end_year',
            'categories',
            'types',
            'genres',
            'freeleech',
            'doubleupload',
            'featured',
            'stream',
            'highspeed',
            'sd',
            'internal',
            'alive',
            'dying',
            'dead',
        ];

        return array_filter($filters, static fn (string $key) => array_key_exists($key, $allowedKeys), ARRAY_FILTER_USE_KEY);
    }
}

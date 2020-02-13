<?php

namespace OwenVoke\Unit3d\Entity;

class Torrent extends AbstractEntity
{
    public int $id;
    public string $name;
    public ?int $releaseYear;
    public string $category;
    public ?string $type;
    public ?string $resolution;
    public int $seeders;
    public int $leechers;
    public int $timesCompleted;
    public ?string $tmdbId;
    public ?string $imdbId;
    public ?string $tvdbId;
    public ?string $malId;
    public ?string $igdbId;
    public ?string $createdAt;
    public string $downloadLink;
}

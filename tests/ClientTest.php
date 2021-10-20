<?php

declare(strict_types=1);

use OwenVoke\UNIT3D\Client;
use OwenVoke\UNIT3D\Api\Torrent;

it('gets instances from the client', function () {
    $client = new Client();

    // Retrieves Torrent instance
    expect($client->torrent())->toBeInstanceOf(Torrent::class);
    expect($client->torrents())->toBeInstanceOf(Torrent::class);
});

<?php

declare(strict_types=1);

namespace OwenVoke\Unit3d\Tests\Feature\Api;

use GuzzleHttp\Psr7\Response;
use OwenVoke\Unit3d\Entity\Torrent as TorrentEntity;
use OwenVoke\Unit3d\Tests\Support\Contracts\InteractsWithApi;
use OwenVoke\Unit3d\Tests\Support\Contracts\InteractsWithFixtures;
use PHPUnit\Framework\TestCase;

final class TorrentTest extends TestCase
{
    use InteractsWithApi, InteractsWithFixtures;

    /** @test */
    public function it_can_get_all_torrents(): void
    {
        $apiWrapper = $this->getMockedApiWrapper([
            new Response(
                200,
                [],
                file_get_contents($this->getFixturesDirectory('responses/torrents.all.json'))
            ),
        ]);

        $response = $apiWrapper->torrents()->getAll();
        /** @var TorrentEntity $first */
        $first = $response[0];

        $this->assertSame(39808, $first->id);
        $this->assertSame('Gwendoline 1984 2in1 1080p Blu-ray AVC DTS-HD MA 5.1', $first->name);
        $this->assertSame(
            'https://blutopia.xyz/torrent/download/39808.8d5b7108db36e46442e71580ab0c2f18',
            $first->downloadLink
        );
    }

    /** @test */
    public function it_can_get_all_torrents_for_a_specific_page(): void
    {
        $apiWrapper = $this->getMockedApiWrapper([
            new Response(
                200,
                [],
                file_get_contents($this->getFixturesDirectory('responses/torrents.all.json'))
            ),
        ]);

        $torrents = $apiWrapper->torrents()->getAll(10);
        /** @var TorrentEntity $torrent */
        $torrent = $torrents[0];

        $this->assertSame(39808, $torrent->id);
        $this->assertSame('Gwendoline 1984 2in1 1080p Blu-ray AVC DTS-HD MA 5.1', $torrent->name);
        $this->assertSame(
            'https://blutopia.xyz/torrent/download/39808.8d5b7108db36e46442e71580ab0c2f18',
            $torrent->downloadLink
        );
    }

    /** @test */
    public function it_can_get_a_single_torrent_by_its_id(): void
    {
        $apiWrapper = $this->getMockedApiWrapper([
            new Response(
                200,
                [],
                file_get_contents($this->getFixturesDirectory('responses/torrents.single.json'))
            ),
        ]);

        $torrent = $apiWrapper->torrents()->get(1);

        $this->assertSame(39765, $torrent->id);
        $this->assertSame('Bad Blood 2017 S01 REPACK 1080p BluRay REMUX AVC FLAC 2.0-BLURANiUM', $torrent->name);
        $this->assertSame(
            'https://blutopia.xyz/torrent/download/39765.8d5b7108db36e46442e71580ab0c2f18',
            $torrent->downloadLink
        );
    }

    /** @test */
    public function it_can_get_filtered_torrents(): void
    {
        $apiWrapper = $this->getMockedApiWrapper([
            new Response(
                200,
                [],
                file_get_contents($this->getFixturesDirectory('responses/torrents.filter.json'))
            ),
        ]);

        $torrents = $apiWrapper->torrents()->filter(1, ['name' => 'Joker 2019']);
        /** @var TorrentEntity $torrent */
        $torrent = $torrents[0];

        $this->assertSame(39248, $torrent->id);
        $this->assertSame('Joker 2019 1080p WEB-DL DD5.1 H264-CMRG', $torrent->name);
        $this->assertSame(
            'https://blutopia.xyz/torrent/download/39248.8d5b7108db36e46442e71580ab0c2f18',
            $torrent->downloadLink
        );
    }
}

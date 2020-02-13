<?php

namespace OwenVoke\Unit3d\Tests\Support\Contracts;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use OwenVoke\Unit3d\Adapter\HttpAdapter;
use OwenVoke\Unit3d\Unit3d;

trait InteractsWithApi
{
    protected function getMockedApiWrapper(array $responses): Unit3d
    {
        $mock = new MockHandler($responses);
        $handlerStack = HandlerStack::create($mock);

        $client = new Client(['handler' => $handlerStack]);
        $adapter = new HttpAdapter('', $client);

        return new Unit3d($adapter, '');
    }
}

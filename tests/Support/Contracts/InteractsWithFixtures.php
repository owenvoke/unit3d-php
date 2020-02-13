<?php

namespace OwenVoke\Unit3d\Tests\Support\Contracts;

trait InteractsWithFixtures
{
    protected function getFixturesDirectory(string $path): string
    {
        return __DIR__."/../../fixtures/{$path}";
    }
}

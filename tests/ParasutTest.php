<?php

namespace TarfinLabs\ParasutLaravel\Tests;

use Orchestra\Testbench\TestCase;
use TarfinLabs\ParasutLaravel\ParasutLaravelServiceProvider;

class ParasutTest extends TestCase
{

    protected function getPackageProviders($app): array
    {
        return [ParasutLaravelServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true(): void
    {
        $this->assertTrue(true);
    }
}

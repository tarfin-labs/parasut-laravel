<?php

namespace TarfinLabs\Parasut\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use TarfinLabs\Parasut\ParasutServiceProvider;

abstract class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        //
    }

    protected function getPackageProviders($app): array
    {
        return [
            ParasutServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        parent::getEnvironmentSetUp($app);
    }
}
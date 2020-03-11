<?php

namespace TarfinLabs\Parasut\Tests;

use Faker\Generator;
use Orchestra\Testbench\TestCase as Orchestra;
use TarfinLabs\Parasut\ParasutServiceProvider;
use Faker\Factory;

abstract class TestCase extends Orchestra
{
    protected Generator $faker;

    public function setUp(): void
    {
        parent::setUp();

        config()->set('app.faker_locale', 'tr_TR');

        $this->faker = Factory::create();
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

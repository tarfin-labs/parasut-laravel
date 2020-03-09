<?php

namespace TarfinLabs\Parasut\Tests;

use Illuminate\Support\Carbon;
use Orchestra\Testbench\TestCase;
use TarfinLabs\Parasut\API\ClientGateway;
use TarfinLabs\Parasut\Mocks\ParasutMock;
use TarfinLabs\Parasut\ParasutServiceProvider;

class AuthenticationTest extends TestCase
{

    protected function getPackageProviders($app): array
    {
        return [ParasutServiceProvider::class];
    }

    /** @test */
    public function user_can_authenticate(): void
    {
        ParasutMock::authentication();

        $parasutClient = app(ClientGateway::class);

        $this->assertNotNull($parasutClient->getAccessToken());
        $this->assertNotNull($parasutClient->getRefreshToken());
        $this->assertInstanceOf(Carbon::class, $parasutClient->getExpiresAt());
    }
}

<?php

namespace TarfinLabs\Parasut\Tests;

use Illuminate\Support\Carbon;
use TarfinLabs\Parasut\API\ClientGateway;
use TarfinLabs\Parasut\Mocks\BaseMock;

class AuthenticationTest extends TestCase
{
    /** @test */
    public function user_can_authenticate(): void
    {
        BaseMock::fakeAuthentication();

        $parasutClient = app(ClientGateway::class);

        $this->assertNotNull($parasutClient->getAccessToken());
        $this->assertNotNull($parasutClient->getRefreshToken());
        $this->assertInstanceOf(Carbon::class, $parasutClient->getExpiresAt());
    }
}

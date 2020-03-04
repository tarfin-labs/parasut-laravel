<?php

namespace TarfinLabs\Parasut\Tests;

use Illuminate\Support\Carbon;
use Orchestra\Testbench\TestCase;
use Illuminate\Support\Facades\Http;
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
        Http::fake([
            config('parasut.api_url').'*' => Http::response([
                'access_token'  => 'fake-access-token',
                'token_type'    => 'bearer',
                'expires_in'    => 7200,
                'refresh_token' => 'fake-refresh-token',
                'scope'         => 'public',
                'created_at'    => 1583243989,
                'created_at'    => Carbon::now()->unix(),
            ], 200, [
                'content-type' => 'application/json; charset=utf-8',
            ]),
        ]);

        $parasutClient = new \TarfinLabs\Parasut\Http\Client();

        $this->assertNotNull($parasutClient->getAccessToken());
        $this->assertNotNull($parasutClient->getRefreshToken());
        $this->assertInstanceOf(Carbon::class, $parasutClient->getExpiresIn());
    }
}

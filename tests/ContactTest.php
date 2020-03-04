<?php

namespace TarfinLabs\Parasut\Tests;

use Orchestra\Testbench\TestCase;
use TarfinLabs\Parasut\Entities\Contact;
use TarfinLabs\Parasut\ParasutServiceProvider;

class ContactTest extends TestCase
{

    protected function getPackageProviders($app): array
    {
        return [ParasutServiceProvider::class];
    }

    /** @test */
    public function contacts_can_list(): void
    {
        //Http::fake([
        //    config('parasut.api_url').'*' => Http::response([
        //        'access_token'  => 'fake-access-token',
        //        'token_type'    => 'bearer',
        //        'expires_in'    => 7200,
        //        'refresh_token' => 'fake-refresh-token',
        //        'scope'         => 'public',
        //        'created_at'    => 1583243989,
        //        'created_at'    => Carbon::now()->unix(),
        //    ], 200, [
        //        'content-type' => 'application/json; charset=utf-8',
        //    ]),
        //]);

        //$client = new \TarfinLabs\Parasut\Entities\Contact();
        $a = 1;
        $parasut = new Contact();

        //$parasutClient = new \TarfinLabs\Parasut\Http\HttpClient();

        //$this->assertNotNull($parasutClient->getAccessToken());
        //$this->assertNotNull($parasutClient->getRefreshToken());
        //$this->assertInstanceOf(Carbon::class, $parasutClient->getExpiresAt());
    }
}

<?php

namespace TarfinLabs\Parasut\Mocks;

use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class ParasutMock
{
    public static function authentication(): void
    {
        Http::fake([
            config('parasut.api_url').'/'.config('parasut.token_url') => Http::response([
                'access_token'  => 'fake-access-token',
                'token_type'    => 'bearer',
                'expires_in'    => 7200,
                'refresh_token' => 'fake-refresh-token',
                'scope'         => 'public',
                'created_at'    => 1583243989,
                'created_at'    => Carbon::now()->unix(),
            ], Response::HTTP_OK, [
                'content-type' => 'application/json; charset=utf-8',
            ]),
        ]);
    }
}
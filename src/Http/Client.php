<?php

namespace TarfinLabs\Parasut\Http;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class Client
{
    // TODO: Cache tokens

    private string $accessToken;
    private string $refreshToken;
    private Carbon $expiresIn;

    public function __construct()
    {
        $this->authenticate();
    }

    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    public function getRefreshToken(): ?string
    {
        return $this->refreshToken;
    }

    public function getExpiresIn(): ?Carbon
    {
        return $this->expiresIn;
    }

    private function authenticate(): bool
    {
        $authenticationParams = [
            'grant_type'    => config('parasut.grant_type'),
            'client_id'     => config('parasut.client_id'),
            'client_secret' => config('parasut.client_secret'),
            'username'      => config('parasut.username'),
            'password'      => config('parasut.password'),
            'redirect_uri'  => config('parasut.redirect_uri'),
        ];

        $response = Http::asForm()
                        ->post(
                            config('parasut.api_url').config('parasut.token_url'),
                            $authenticationParams
                        );

        if ($response->successful())
        {
            $this->accessToken = $response->json()['access_token'];
            $this->refreshToken = $response->json()['refresh_token'];
            $this->expiresIn = Carbon::now()->addSeconds($response->json()['expires_in']);


            return true;
        }

        return false;
    }
}

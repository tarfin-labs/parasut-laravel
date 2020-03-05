<?php

namespace TarfinLabs\Parasut\API;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class HttpClientGateway implements ClientGateway
{
    // TODO: Cache tokens

    private string $grantType;
    private string $clientId;
    private string $clientSecret;
    private string $username;
    private string $password;
    private string $redirectUri;

    private string $accessToken;
    private string $refreshToken;
    private Carbon $expiresAt;

    private string $baseEntpoint;

    public function __construct(
        string $grantType,
        string $clientId,
        string $clientSecret,
        string $username,
        string $password,
        string $redirectUri
    ) {
        $this->grantType = $grantType;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->username = $username;
        $this->password = $password;
        $this->redirectUri = $redirectUri;

        $this->baseEntpoint = implode('/',[
            config('parasut.api_url'),
            config('parasut.api_version'),
            config('parasut.company_id'),
        ]);

        $this->authenticate();
    }

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    public function getExpiresAt(): ?Carbon
    {
        return $this->expiresAt;
    }

    /**
     * Authenticate user and get API tokens from parasut.com.
     *
     * @return bool
     */
    public function authenticate(): bool
    {
        $response = Http::asForm()
                        ->post(
                            implode('/', [
                                config('parasut.api_url'),config('parasut.token_url')
                            ]),
                            [
                                'grant_type'    => $this->grantType,
                                'client_id'     => $this->clientId,
                                'client_secret' => $this->clientSecret,
                                'username'      => $this->username,
                                'password'      => $this->password,
                                'redirect_uri'  => $this->redirectUri,
                            ]
                        );

        if ($response->successful())
        {
            $this->accessToken = $response->json()['access_token'];
            $this->refreshToken = $response->json()['refresh_token'];
            $this->expiresAt = Carbon::now()->addSeconds($response->json()['expires_in']);

            return true;
        }

        return false;
    }

    public function call(
        string $method,
        string $endpoint,
        array $filters = null,
        array $sorts = null,
        array $includes = null,
        array $body = null,
        int $page = 1,
        int $pageSize = 15
    ): array {
        $queryString = http_build_query(array_filter([
            'filter' => $filters,
            'sort' => implode(',', $sorts),
            'include' => implode(',', $includes),
            'page[number]' => $page,
            'page[size]' => $pageSize ,
        ]));

        $b = implode('?', [$this->baseEntpoint.'/'.$endpoint, $queryString]);

        $response = Http::withToken($this->getAccessToken())
                        ->send('GET', $b);

        return $response->json();
    }
}

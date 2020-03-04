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

    public function __construct(
        string $grantType,
        string $clientId,
        string $clientSecret,
        string $username,
        string $password,
        string $redirectUri
    )
    {
        $this->$grantType = $grantType;
        $this->$clientId = $clientId;
        $this->$clientSecret = $clientSecret;
        $this->$username = $username;
        $this->$password = $password;
        $this->$redirectUri = $redirectUri;

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

    public function getExpiresAt(): ?Carbon
    {
        return $this->expiresAt;
    }

    public function authenticate(): bool
    {
        $authenticationParams = [
            'grant_type'    => $this->grantType,
            'client_id'     => $this->clientId,
            'client_secret' => $this->clientSecret,
            'username'      => $this->username,
            'password'      => $this->password,
            'redirect_uri'  => $this->redirectUri,
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
            $this->expiresAt = Carbon::now()->addSeconds($response->json()['expires_in']);

            return true;
        }

        return false;
    }

    public function call($method, $endpoint, $queryParams = [], $bodyParams = [], $headers = [])
    {
        $options = [
            'headers' => [
                'Authorization' => 'Bearer '.$this->token,
                'Accept'        => 'application/json',
            ],
            'json'    => $bodyParams,
        ];

        $options['headers'] = array_merge($options['headers'], $headers);
        $url = $this->apiUrl.'/'.$endpoint;
        $url .= empty($queryParams) ? '' : '?'.http_build_query($queryParams);
        $response = $this->httpClient->request($method, $url, $options);

        return json_decode($response->getBody()->getContents(), true);
    }
}

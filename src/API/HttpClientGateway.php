<?php

namespace TarfinLabs\Parasut\API;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use RuntimeException;
use TarfinLabs\Parasut\Exceptions\BadRequestException;
use TarfinLabs\Parasut\Exceptions\ForbiddenException;
use TarfinLabs\Parasut\Exceptions\NotFoundException;
use TarfinLabs\Parasut\Exceptions\TooManyRequestsException;
use TarfinLabs\Parasut\Exceptions\UnauthorizedException;
use TarfinLabs\Parasut\Exceptions\UnprocessableEntityException;

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

        $this->baseEntpoint = implode('/', [
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
     * @throws \TarfinLabs\Parasut\Exceptions\BadRequestException
     * @throws \TarfinLabs\Parasut\Exceptions\ForbiddenException
     * @throws \TarfinLabs\Parasut\Exceptions\NotFoundException
     * @throws \TarfinLabs\Parasut\Exceptions\TooManyRequestsException
     * @throws \TarfinLabs\Parasut\Exceptions\UnauthorizedException
     * @throws \TarfinLabs\Parasut\Exceptions\UnprocessableEntityException
     */
    public function authenticate(): bool
    {
        $response = Http::asForm()
                        ->post(
                            implode('/', [
                                config('parasut.api_url'),
                                config('parasut.token_url'),
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

        if ($response->successful()) {
            $this->accessToken = $response->json()['access_token'];
            $this->refreshToken = $response->json()['refresh_token'];
            $this->expiresAt = Carbon::now()->addSeconds($response->json()['expires_in']);

            return true;
        }

        $this->catchException($response);
    }

    protected function buildHttpQuery(
        $filters = null,
        $sorts = null,
        $includes = null,
        $page = null,
        $pageSize = null
    ): string {
        return http_build_query(
            array_filter([
                'filter'       => $filters,
                'sort'         => ! empty($sorts) ? implode(',', $sorts) : null,
                'include'      => ! empty($includes) ? implode(',', $includes) : null,
                'page[number]' => $page,
                'page[size]'   => $pageSize,
            ]));
    }

    public function send(
        string $method,
        array $endpoints,
        array $filters = null,
        array $sorts = null,
        array $includes = null,
        array $body = null,
        ?int $page,
        ?int $pageSize
    ): ?array {
        $endpointsUrl = implode('/', $endpoints);
        $url = implode('/', [$this->baseEntpoint, $endpointsUrl]);

        $queryString = $this->buildHttpQuery($filters, $sorts, $includes, $page, $pageSize);

        if (! empty($queryString)) {
            $url = implode('?', [$queryString]);
        }

        $response = Http::withToken($this->getAccessToken())
                        ->send($method, $url, ['json' => $body]);

        if ($response->successful()) {
            return $response->json();
        }

        $this->catchException($response);
    }

    /**
     * Catches the status code and throws appropriate exception.
     *
     * @param  \Illuminate\Http\Client\Response  $response
     *
     * @throws \TarfinLabs\Parasut\Exceptions\BadRequestException
     * @throws \TarfinLabs\Parasut\Exceptions\ForbiddenException
     * @throws \TarfinLabs\Parasut\Exceptions\NotFoundException
     * @throws \TarfinLabs\Parasut\Exceptions\TooManyRequestsException
     * @throws \TarfinLabs\Parasut\Exceptions\UnauthorizedException
     * @throws \TarfinLabs\Parasut\Exceptions\UnprocessableEntityException
     */
    protected function catchException(Response $response): void
    {
        switch ($response->status()) {
            case BadRequestException::$statusCode:
                throw new BadRequestException($response);
                break;
            case ForbiddenException::$statusCode:
                throw new ForbiddenException($response);
                break;
            case NotFoundException::$statusCode:
                throw new NotFoundException($response);
                break;
            case TooManyRequestsException::$statusCode:
                throw new TooManyRequestsException($response);
                break;
            case UnauthorizedException::$statusCode:
                throw new UnauthorizedException($response);
                break;
            case UnprocessableEntityException::$statusCode:
                throw new UnprocessableEntityException($response);
                break;
            default:
                throw new RuntimeException("Unknown Paraşüt Exception: {$response->status()}");
                break;
        }
    }
}

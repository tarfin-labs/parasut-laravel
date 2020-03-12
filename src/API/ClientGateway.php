<?php

namespace TarfinLabs\Parasut\API;

use Illuminate\Support\Carbon;

interface ClientGateway
{
    public function send(
        string $method,
        array $endpoints,
        array $filters = null,
        array $sorts = null,
        array $includes = null,
        array $body = null,
        ?int $page,
        ?int $pageSize
    ): ?array;

    public function getAccessToken(): string;

    public function getRefreshToken(): string;

    public function authenticate(): bool;

    public function getExpiresAt(): ?Carbon;
}

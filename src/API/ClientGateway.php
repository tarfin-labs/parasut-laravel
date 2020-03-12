<?php

namespace TarfinLabs\Parasut\API;

interface ClientGateway
{
    public function send(
        string $method,
        string $endpoint,
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
}

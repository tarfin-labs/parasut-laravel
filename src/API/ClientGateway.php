<?php

namespace TarfinLabs\Parasut\API;

interface ClientGateway
{
    public function getAccessToken(): string;

    public function getRefreshToken(): string;

    public function authenticate(): bool;
}

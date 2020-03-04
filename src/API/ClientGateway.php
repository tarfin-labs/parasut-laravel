<?php

namespace TarfinLabs\Parasut\API;

interface ClientGateway
{
    public function authenticate(): bool;
}
<?php

namespace TarfinLabs\Parasut\Entities;

use TarfinLabs\Parasut\API\ClientGateway;

abstract class BaseEntitiy
{
    protected ClientGateway $clientGateway;
    protected string $endpoint;
    protected array $availableSorts;
    protected array $availableIncludes;
    protected array $availableFilters;

    public function __construct()
    {
        $this->clientGateway = app(ClientGateway::class);
    }

}
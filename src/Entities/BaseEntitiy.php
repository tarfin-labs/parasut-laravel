<?php

namespace TarfinLabs\Parasut\Entities;

abstract class BaseEntitiy
{
    protected ClientContract $client;
    protected string $endpoint;
    protected array $availableSorts;
    protected array $availableIncludes;
    protected array $availableFilters;

    public function __construct(ClientContract $client)
    {
        $this->client = $client;
    }

    public function all(array $parameters)
    {
        $this->client->call('GET', $this->endpoint, $parameters);
    }

}
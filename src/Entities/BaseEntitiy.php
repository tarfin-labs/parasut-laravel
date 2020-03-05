<?php

namespace TarfinLabs\Parasut\Entities;

use TarfinLabs\Parasut\API\ClientGateway;
use TarfinLabs\Parasut\Enums\HttpMethods;

abstract class BaseEntitiy
{
    protected ClientGateway $clientGateway;

    protected string $endpoint;

    protected array $sorts = [];
    protected array $filters = [];
    protected array $includes = [];
    protected int $page = 1;
    protected int $pageSize = 25;

    public function __construct(ClientGateway $clientGateway)
    {
        $this->clientGateway = $clientGateway;
    }

    public function all()
    {
        return $this->clientGateway->call(
            HttpMethods::GET,
            $this->endpoint,
            $this->filters,
            $this->sorts,
            $this->includes,
            null,
            $this->page,
            $this->pageSize
        );
    }

}
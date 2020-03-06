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
    protected int $page;
    protected int $pageSize;

    /**
     * BaseEntitiy constructor.
     *
     * @param  \TarfinLabs\Parasut\API\ClientGateway  $clientGateway
     */
    public function __construct()
    {
        $this->clientGateway = app(ClientGateway::class);
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
            $this->page ?? null,
            $this->pageSize ?? null
        );
    }

    /**
     * @param  int  $id
     *
     * @return array
     */
    public function find(int $id): array
    {
        return $this->clientGateway->call(
            HttpMethods::GET,
            implode('/', [$this->endpoint, $id])
        )['data'];
    }

    /**
     * @param  int  $perPage
     * @param  int  $pageNumber
     *
     * @return \TarfinLabs\Parasut\Entities\BaseEntitiy
     */
    public function paginate(int $perPage, int $pageNumber = 1): BaseEntitiy
    {
        $this->pageSize = $perPage;
        $this->page = $pageNumber;

        return $this;
    }

    /**
     * @param  string  $attribute
     * @param  bool    $descending
     *
     * @return \TarfinLabs\Parasut\Entities\BaseEntitiy
     */
    public function sortByAttribute(string $attribute, bool $descending = false): BaseEntitiy
    {
        $this->sorts[] = ($descending ? '-' : '').$attribute;

        return $this;
    }

}
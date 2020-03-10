<?php

namespace TarfinLabs\Parasut\Repositories;

use TarfinLabs\Parasut\API\ClientGateway;
use TarfinLabs\Parasut\Enums\HttpMethods;

class BaseRepository
{
    protected ClientGateway $clientGateway;

    protected string $endpoint;
    protected string $model;

    protected Meta $meta;
    protected Links $links;

    protected array $sorts = [];
    protected array $filters = [];
    protected array $includes = [];
    protected int $page;
    protected int $pageSize;

    public function __construct()
    {
        $this->clientGateway = app(ClientGateway::class);
    }

    public function all()
    {
        $rawData = $this->clientGateway->call(
            HttpMethods::GET,
            $this->endpoint,
            $this->filters,
            $this->sorts,
            $this->includes,
            null,
            $this->page ?? null,
            $this->pageSize ?? null
        );

        $this->meta = new Meta($rawData['meta']);
        $this->links = new Links($rawData['links']);

        // TODO: Find a way to remove initilize model with sushi without a draft record creation
        $this->model::first()->delete();

        $this->model::insert(
            array_map(function ($item) {
                $mappings = [];
                $mappings['id'] = $item['id'];

                foreach ((new $this->model)->getFillable() as $field) {
                    $mappings[$field] = $item['attributes'][$field];
                }

                return $mappings;
            }, $rawData['data'])
        );

        return $this->model::all();
    }

    public function find(int $id): array
    {
        return $this->clientGateway->call(
            HttpMethods::GET,
            implode('/', [$this->endpoint, $id])
        )['data'];
    }

    public function sortByAttribute(string $attribute, bool $descending = false): BaseRepository
    {
        $this->sorts[] = ($descending ? '-' : '').$attribute;

        return $this;
    }

    public function paginate(int $perPage, int $pageNumber): BaseRepository
    {
        $this->pageSize = $perPage;
        $this->page = $pageNumber;

        return $this;
    }
}
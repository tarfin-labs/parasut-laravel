<?php

namespace TarfinLabs\Parasut\Repositories;

use TarfinLabs\Parasut\Models\BaseModel;
use TarfinLabs\Parasut\Enums\HttpMethods;
use TarfinLabs\Parasut\API\ClientGateway;
use Illuminate\Database\Eloquent\Collection;

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

    // region CRUD

    public function all(): Collection
    {
        $rawData = $this->clientGateway->send(
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

        $this->model::insert($this->multipleRawDataToAttributes($rawData['data']));

        return $this->model::all();
    }

    public function find(int $id): ?BaseModel
    {
        $rawData = $this->clientGateway->send(
            HttpMethods::GET,
            $this->endpoint.'/'.$id,
            null,
            null,
            $this->includes,
            null,
            null,
            null
        );

        $attributes = $this->rawDataToAttributes($rawData['data']);

        $this->model::insert($attributes);

        return $this->model::find($attributes['id']);
    }

    public function create(BaseModel $model): BaseModel
    {
        $rawData = $this->clientGateway->send(
            HttpMethods::POST,
            $this->endpoint,
            null,
            null,
            $this->includes,
            $this->generateCreationBodyForModel($model),
            null,
            null
        );

        $attributes = $this->rawDataToAttributes($rawData['data']);

        $this->model::insert($attributes);

        return $this->model::find($attributes['id']);
    }

    public function update(BaseModel $model): ?BaseModel
    {
        $rawData = $this->clientGateway->send(
            HttpMethods::PUT,
            $this->endpoint.'/'.$model->id,
            null,
            null,
            $this->includes,
            $this->generateCreationBodyForModel($model),
            null,
            null
        );

        $attributes = $this->rawDataToAttributes($rawData['data']);

        $model->update($attributes);

        return $model;
    }

    // endregion

    // region Supports

    protected function generateCreationBodyForModel(BaseModel $model): array
    {
        $attributes = [];

        foreach ($model->getAttributes() as $name => $value) {
            if (! empty($value)) {
                $attributes[$name] = $value;
            }
        }

        return [
            'data' => [
                'type'       => $this->endpoint,
                'attributes' => $attributes,
                'relationships' => [],
            ],
        ];
    }

    // TODO: Merge `rawDataToAttributes()` and `multipleRawDataToAttributes()`

    protected function rawDataToAttributes(array $rawData): array
    {
        $mappings = [];
        $mappings['id'] = $rawData['id'];

        foreach ((new $this->model)->getFillable() as $field) {
            $mappings[$field] = $rawData['attributes'][$field];
        }

        return $mappings;
    }

    protected function multipleRawDataToAttributes(array $rawData): array
    {
        return array_map(function ($item) {
            $mappings = [];
            $mappings['id'] = $item['id'];

            foreach ((new $this->model)->getFillable() as $field) {
                $mappings[$field] = $item['attributes'][$field];
            }

            return $mappings;
        }, $rawData);
    }

    // endregion

    // region Helpers

    public function sortByAttribute(string $attribute, bool $descending = false): self
    {
        $this->sorts[] = ($descending ? '-' : '').$attribute;

        return $this;
    }

    public function paginate(int $perPage, int $pageNumber): self
    {
        $this->pageSize = $perPage;
        $this->page = $pageNumber;

        return $this;
    }

    // endregion
}

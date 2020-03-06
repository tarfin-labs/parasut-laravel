<?php

namespace TarfinLabs\Parasut\Models;

use Sushi\Sushi;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use Sushi;

    protected ClientGateway $clientGateway;

    protected string $endpoint;

    protected array $sorts = [];
    protected array $filters = [];
    protected array $includes = [];
    protected int $page;
    protected int $pageSize;

    public function getRows()
    {
        $this->clientGateway = app(ClientGateway::class);

        $data =  $this->clientGateway->call(
            HttpMethods::GET,
            $this->endpoint,
            $this->filters,
            $this->sorts,
            $this->includes,
            null,
            $this->page ?? null,
            $this->pageSize ?? null
        );

        // TODO: Process json and return data array

        return $data;
    }

    public function sortByAttribute(string $attribute, bool $descending = false): BaseEntitiy
    {
        $this->sorts[] = ($descending ? '-' : '').$attribute;

        return $this;
    }
}
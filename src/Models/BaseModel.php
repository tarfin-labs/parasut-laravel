<?php

namespace TarfinLabs\Parasut\Models;

use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class BaseModel extends Model
{
    use Sushi;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->fillable = array_keys($this->schema);
    }

    public function getRows(): array
    {
        return [array_merge(['id' => 'integer'], $this->schema)];
    }
}

<?php

namespace TarfinLabs\Parasut\Repositories;

use TarfinLabs\Parasut\Models\Product;
use TarfinLabs\Parasut\Repositories\Meta\BaseMeta;
use TarfinLabs\Parasut\Repositories\Meta\ProductMeta;

class ProductRepository extends BaseRepository
{
    protected string $endpoint = 'products';
    protected string $model = Product::class;

    // region Sorts

    public function sortById(bool $descending = false): self
    {
        return $this->sortByAttribute('id', $descending);
    }

    public function sortByName(bool $descending = false): self
    {
        return $this->sortByAttribute('name', $descending);
    }

    // endregion

    // region Filters

    public function findByName(string $name): self
    {
        $this->filters['name'] = $name;

        return $this;
    }

    public function findByCode(string $code): self
    {
        $this->filters['code'] = $code;

        return $this;
    }

    // endregion

    // region Includes

    public function includeCategory(): self
    {
        $this->includes[] = 'category';

        return $this;
    }

    // endregion

    // region Meta

    protected static function createMeta(array $meta): BaseMeta
    {
        return new ProductMeta($meta);
    }

    // endregion
}

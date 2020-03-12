<?php

namespace TarfinLabs\Parasut\Repositories\Meta;

class ContactMeta extends BaseMeta
{
    public ?float $payableTotal;
    public ?float $collectibleTotal;

    public function __construct(array $meta)
    {
        parent::__construct($meta);

        $this->payableTotal = $meta['payable_total'] ?? null;
        $this->collectibleTotal = $meta['collectible_total'] ?? null;
    }
}

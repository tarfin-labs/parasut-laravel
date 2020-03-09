<?php

namespace TarfinLabs\Parasut\Repositories;

class Links
{
    public string $self;
    public string $next;
    public string $last;

    public function __construct(array $links)
    {
        $this->self = $links['self'];
        $this->next = $links['next'];
        $this->last = $links['last'];
    }
}
<?php

namespace TarfinLabs\Parasut\Repositories;

class Meta
{
    public int    $currentPage;
    public int    $totalPages;
    public int    $totalCount;
    public int    $perPage;
    public string $exportUrl;

    // TODO: Look if other models has `payable_total` and `collectible_total` attributes
    // TODO: They don't have that attributes

    public function __construct(array $meta)
    {
        $this->currentPage = $meta['current_page'];
        $this->totalPages = $meta['total_pages'];
        $this->totalCount = $meta['total_count'];
        $this->perPage = $meta['per_page'];
        $this->exportUrl = $meta['export_url'];
    }
}

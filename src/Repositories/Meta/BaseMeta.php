<?php

namespace TarfinLabs\Parasut\Repositories\Meta;

abstract class BaseMeta
{
    public ?int    $currentPage;
    public ?int    $totalPages;
    public ?int    $totalCount;
    public ?int    $perPage;
    public ?string $exportUrl;

    public function __construct(array $meta)
    {
        $this->currentPage = $meta['current_page'] ?? null;
        $this->totalPages = $meta['total_pages'] ?? null;
        $this->totalCount = $meta['total_count'] ?? null;
        $this->perPage = $meta['per_page'] ?? null;
        $this->exportUrl = $meta['export_url'] ?? null;
    }
}

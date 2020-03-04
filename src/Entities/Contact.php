<?php

namespace TarfinLabs\Parasut\Entities;

class Contact extends BaseEntitiy
{
    protected string $endpoint = 'contacts';

    protected array $availableSorts = [
        'id',
        'balance',
        'name',
        'email',
    ];

    protected array $availableFilters = [
        'name',
        'email',
        'tax_number',
        'tax_office',
        'city',
    ];

    protected array $availableIncludes = [
        'category',
        'contact_portal',
        'contact_people',
    ];
}
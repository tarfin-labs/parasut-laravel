<?php

namespace TarfinLabs\Parasut\Repositories;

use TarfinLabs\Parasut\Models\Contact;
use TarfinLabs\Parasut\Repositories\Meta\BaseMeta;
use TarfinLabs\Parasut\Repositories\Meta\ContactMeta;

class ContactRepository extends BaseRepository
{
    protected string $endpoint = 'contacts';
    protected string $model = Contact::class;

    // region Sorts

    public function sortById(bool $descending = false): self
    {
        return $this->sortByAttribute('id', $descending);
    }

    public function sortByBalance(bool $descending = false): self
    {
        return $this->sortByAttribute('balance', $descending);
    }

    public function sortByName(bool $descending = false): self
    {
        return $this->sortByAttribute('name', $descending);
    }

    public function sortByEmail(bool $descending = false): self
    {
        return $this->sortByAttribute('email', $descending);
    }

    // endregion

    // region Filters

    public function findByName(string $name): self
    {
        $this->filters['name'] = $name;

        return $this;
    }

    public function findByEmail(string $email): self
    {
        $this->filters['email'] = $email;

        return $this;
    }

    public function findByTaxNumber(string $taxNumber): self
    {
        $this->filters['tax_number'] = $taxNumber;

        return $this;
    }

    public function findByTaxOffice(string $taxOffice): self
    {
        $this->filters['tax_office'] = $taxOffice;

        return $this;
    }

    public function findByCity(string $city): self
    {
        $this->filters['city'] = $city;

        return $this;
    }

    // endregion

    // region Includes

    public function includeCategory(): self
    {
        $this->includes[] = 'category';

        return $this;
    }

    public function includeContactPortal(): self
    {
        $this->includes[] = 'contact_portal';

        return $this;
    }

    public function includeContactPeople(): self
    {
        $this->includes[] = 'contact_people';

        return $this;
    }

    // endregion

    // region Meta

    protected static function createMeta(array $meta): BaseMeta
    {
        return new ContactMeta($meta);
    }

    // endregion
}

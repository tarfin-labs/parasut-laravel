<?php

namespace TarfinLabs\Parasut\Repositories;

use TarfinLabs\Parasut\Models\Contact;

class ContactRepository extends BaseRepository
{
    protected string $endpoint = 'contacts';
    protected string $model = Contact::class;

     // region Sorts

    public function sortById(bool $descending = false): ContactRepository
    {
        return $this->sortByAttribute('id', $descending);
    }

    public function sortByBalance(bool $descending = false): ContactRepository
    {
        return $this->sortByAttribute('balance', $descending);
    }

    public function sortByName(bool $descending = false): ContactRepository
    {
        return $this->sortByAttribute('name', $descending);
    }

    public function sortByEmail(bool $descending = false): ContactRepository
    {
        return $this->sortByAttribute('email', $descending);
    }

    // endregion

    // region Filters

    public function findByName(string $name): ContactRepository
    {
        $this->filters['name'] = $name;

        return $this;
    }

    public function findByEmail(string $email): ContactRepository{
        $this->filters['email'] = $email;

        return $this;
    }

    public function findByTaxNumber(string $taxNumber): ContactRepository
    {
        $this->filters['tax_number'] = $taxNumber;

        return $this;
    }

    public function findByTaxOffice(string $taxOffice): ContactRepository
    {
        $this->filters['tax_office'] = $taxOffice;

        return $this;
    }

    public function findByCity(string $city): ContactRepository
    {
        $this->filters['city'] = $city;

        return $this;
    }

    // endregion

    // region Includes

    public function includeCategory(): ContactRepository
    {
        $this->includes[] = 'category';

        return $this;
    }

    public function includeContactPortal(): ContactRepository
    {
        $this->includes[] = 'contact_portal';

        return $this;
    }

    public function includeContactPeople(): ContactRepository
    {
        $this->includes[] = 'contact_people';

        return $this;
    }

    // endregion
}
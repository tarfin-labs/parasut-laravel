<?php

namespace TarfinLabs\Parasut\Entities;

class Contact extends BaseEntitiy
{
    protected string $endpoint = 'contacts';

    // region Sorts

    public function sortById(bool $descending = false): Contact
    {
        return $this->sortByAttribute('id', $descending);
    }

    public function sortByBalance(bool $descending = false): Contact
    {
        return $this->sortByAttribute('balance', $descending);
    }

    public function sortByName(bool $descending = false): Contact
    {
        return $this->sortByAttribute('name', $descending);
    }

    public function sortByEmail(bool $descending = false): Contact
    {
        return $this->sortByAttribute('email', $descending);
    }

    // endregion

    // region Filters

    public function findByName(string $name): Contact
    {
        $this->filters['name'] = $name;

        return $this;
    }

    public function findByEmail(string $email): Contact{
        $this->filters['email'] = $email;

        return $this;
    }

    public function findByTaxNumber(string $taxNumber): Contact
    {
        $this->filters['tax_number'] = $taxNumber;

        return $this;
    }

    public function findByTaxOffice(string $taxOffice): Contact
    {
        $this->filters['tax_office'] = $taxOffice;

        return $this;
    }

    public function findByCity(string $city): Contact
    {
        $this->filters['city'] = $city;

        return $this;
    }

    // endregion

    // region Includes

    public function includeCategory(): Contact
    {
        $this->includes[] = 'category';

        return $this;
    }

    public function includeContactPortal(): Contact
    {
        $this->includes[] = 'contact_portal';

        return $this;
    }

    public function includeContactPeople(): Contact
    {
        $this->includes[] = 'contact_people';

        return $this;
    }

    // endregion
}
<?php

namespace TarfinLabs\Parasut\Models;

class Customer extends BaseModel
{
    protected string $endpoint = 'contacts';

    protected $fillable = [
        'id',
        'created_at',
        'updated_at',
        'contact_type',
        'name',
        'email',
        'short_name',
        'balance',
        'trl_balance',
        'usd_balance',
        'eur_balance',
        'gbp_balance',
        'tax_number',
        'tax_office',
        'archived',
        'account_type',
        'city',
        'district',
        'address',
        'phone',
        'fax',
        'is_abroad',
        'term_days',
        'sharings_count',
        'exchange_rate_type',
        'iban',
        'sharing_preview_url',
        'sharing_preview_path',
        'payment_reminder_preview_url',
    ];

    // region Sorts

    public function sortById(bool $descending = false): Customer
    {
        return $this->sortByAttribute('id', $descending);
    }

    // endregion


}
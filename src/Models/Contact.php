<?php

namespace TarfinLabs\Parasut\Models;

class Contact extends BaseModel
{
    protected $schema = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'contact_type' => 'string',
        'name' => 'string',
        'email' => 'string',
        'short_name' => 'string',
        'balance' => 'float',
        'trl_balance' => 'float',
        'usd_balance' => 'float',
        'eur_balance' => 'float',
        'gbp_balance' => 'float',
        'tax_number' => 'string',
        'tax_office' => 'string',
        'archived' => 'boolean',
        'account_type' => 'string',
        'city' => 'string',
        'district' => 'string',
        'address' => 'string',
        'phone' => 'string',
        'fax' => 'string',
        'is_abroad' => 'boolean',
        'term_days' => 'integer',
        //'invoicing_preferences' => 'array',
        'sharings_count' => 'integer',
        //'ibans' => 'array',
        'exchange_rate_type' => 'string',
        'iban' => 'string',
        'sharing_preview_url' => 'string',
        'sharing_preview_path' => 'string',
        'payment_reminder_preview_url' => 'string',
    ];
}
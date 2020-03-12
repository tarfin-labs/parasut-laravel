<?php

namespace TarfinLabs\Parasut\Models;

class Product extends BaseModel
{
    protected $schema = [
        'name'                           => 'string',
        'code'                           => 'string',
        'vat_rate'                       => 'float',
        'sales_excise_duty'              => 'float',
        'sales_excise_duty_type'         => 'string',
        'purchase_excise_duty'           => 'float',
        'purchase_excise_duty_type'      => 'string',
        'unit'                           => 'string',
        'communications_tax_rate'        => 'float',
        'archived'                       => 'boolean',
        'list_price'                     => 'float',
        'currency'                       => 'string',
        'buying_price'                   => 'float',
        'buying_currency'                => 'string',
        'inventory_tracking'             => 'boolean',
        'initial_stock_count'            => 'float',
        'sales_excise_duty_code'         => 'string',
        'sales_invoice_details_count'    => 'integer',
        'purchase_invoice_details_count' => 'integer',
        'list_price_in_trl'              => 'float',
        'buying_price_in_trl'            => 'float',
        'stock_count'                    => 'float',
        'created_at'                     => 'datetime',
        'updated_at'                     => 'datetime',
    ];
}

<?php

namespace TarfinLabs\Parasut\Factories;

use Faker\Generator as Faker;
use TarfinLabs\Parasut\Models\Product;

/* @var $factory \Illuminate\Database\Eloquent\Factory */

$factory->define(Product::class, fn(Faker $faker, array $attributes) => [
    'name' => $attributes['name'] ?? $faker->word.'#TEST#',
]);

$factory->state(Product::class, 'creation', fn(Faker $faker, array $attributes) => [
    'code'                      => $attributes['code'] ?? $faker->numberBetween(1, 100),
    'vat_rate'                  => $attributes['vat_rate'] ?? $faker->randomElement([0, 1, 8, 18]),
    'sales_excise_duty'         => $attributes['sales_excise_duty'] ?? $faker->randomFloat(2, 1, 100),
    'sales_excise_duty_type'    => $attributes['sales_excise_duty_type'] ?? $faker->randomElement(['percentage', 'amount']),
    'purchase_excise_duty'      => $attributes['purchase_excise_duty'] ?? $faker->randomFloat(2, 1, 100),
    'purchase_excise_duty_type' => $attributes['purchase_excise_duty_type'] ?? $faker->randomElement(['percentage', 'amount']),
    'unit'                      => $attributes['unit'] ?? $faker->words(2, true).$faker->lexify('???'),
    'communications_tax_rate'   => $attributes['communications_tax_rate'] ?? $attributes['purchase_excise_duty'] ?? $faker->randomFloat(2, 1, 100),
    'archived'                  => $attributes['archived'] ?? $faker->boolean,
    'list_price'                => $attributes['list_price'] ?? $faker->randomFloat(2, 1, 100),
    'currency'                  => $attributes['currency'] ?? $faker->randomElement(['TRL']),
    'buying_price'              => $attributes['buying_price'] ?? $faker->randomFloat(2, 1, 100),
    'buying_currency'           => $attributes['buying_currency'] ?? $faker->randomElement(['TRL']),
    'inventory_tracking'        => $attributes['inventory_tracking'] ?? $faker->boolean,
    'initial_stock_count'       => $attributes['initial_stock_count'] ?? 0.0,
]);

$factory->state(Product::class, 'response', fn(Faker $faker, array $attributes) => [
    'sales_excise_duty_code'         => $attributes['sales_excise_duty_code'] ?? null,
    'sales_invoice_details_count'    => $attributes['sales_invoice_details_count'] ?? 0,
    'purchase_invoice_details_count' => $attributes['purchase_invoice_details_count'] ?? 0,
    'list_price_in_trl'              => $attributes['list_price_in_trl'] ?? $faker->randomFloat(2, 1, 100),
    'buying_price_in_trl'            => $attributes['buying_price_in_trl'] ?? $faker->randomFloat(2, 1, 100),
    'stock_count'                    => $attributes['stock_count'] ?? 0.0,
    'created_at'                     => $attributes['created_at'] ?? $faker->iso8601,
    'updated_at'                     => $attributes['updated_at'] ?? $faker->iso8601,
]);

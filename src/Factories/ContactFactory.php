<?php

namespace TarfinLabs\Parasut\Factories;

use Faker\Generator as Faker;
use TarfinLabs\Parasut\Models\Contact;

/* @var $factory \Illuminate\Database\Eloquent\Factory */

$factory->define(Contact::class, fn(Faker $faker, array $attributes) => [
    'name'         => $attributes['name'] ?? $faker->name.'#TEST#',
    'account_type' => $attributes['account_type'] ?? $faker->randomElement(['customer', 'supplier']),
]);

$factory->state(Contact::class, 'creation', fn(Faker $faker, array $attributes) => [
    'email'        => $attributes['email'] ?? $faker->email,
    'name'         => $attributes['name'] ?? $faker->name.'#TEST#',
    'short_name'   => $attributes['short_name'] ?? null,
    'contact_type' => $attributes['contact_type'] ?? $faker->randomElement(['person', 'company']),
    'tax_office'   => $attributes['tax_office'] ?? $faker->city.' Vergi Dairesi',
    'tax_number'   => $attributes['tax_number'] ?? $faker->numerify('###########'),
    'district'     => $attributes['district'] ?? $faker->city,
    'city'         => $attributes['city'] ?? $faker->city,
    'address'      => $attributes['address'] ?? $faker->address,
    'phone'        => $attributes['phone'] ?? $faker->phoneNumber,
    'fax'          => $attributes['fax'] ?? $faker->phoneNumber,
    'is_abroad'    => $attributes['is_abroad'] ?? $faker->boolean,
    'archived'     => $attributes['archived'] ?? $faker->boolean,
    'iban'         => $attributes['iban'] ?? null,
    'account_type' => $attributes['account_type'] ?? $faker->randomElement(['customer', 'supplier']),
]);

$factory->state(Contact::class, 'response', fn(Faker $faker, array $attributes) => [
    'balance'                      => $attributes['balance'] ?? $faker->randomFloat(2, 100, 9999),
    'trl_balance'                  => $attributes['trl_balance'] ?? $faker->randomFloat(2, 100, 9999),
    'usd_balance'                  => $attributes['usd_balance'] ?? $faker->randomFloat(2, 100, 9999),
    'eur_balance'                  => $attributes['eur_balance'] ?? $faker->randomFloat(2, 100, 9999),
    'gbp_balance'                  => $attributes['gbp_balance'] ?? $faker->randomFloat(2, 100, 9999),
    'term_days'                    => $attributes['term_days'] ?? null,
    'invoicing_preferences'        => $attributes['invoicing_preferences'] ?? [],
    'sharings_count'               => $attributes['sharings_count'] ?? 0,
    'ibans'                        => $attributes['ibans'] ?? [],
    'exchange_rate_type'           => $attributes['exchange_rate_type'] ?? 'buying',
    'sharing_preview_url'          => $attributes['sharing_preview_url'] ?? 'https://uygulama.parasut.com/'.$faker->numberBetween(1000, 9999).'/portal/preview/'.$faker->numberBetween(1000, 9999),
    'sharing_preview_path'         => $attributes['sharing_preview_path'] ?? '/'.$faker->numberBetween(1000, 9999).'/portal/preview/'.$faker->numberBetween(1000, 9999),
    'payment_reminder_preview_url' => $attributes['payment_reminder_preview_url'] ?? 'https://uygulama.parasut.com/'.$faker->numberBetween(1000, 9999).'/portal/preview/'.$faker->numberBetween(1000, 9999).'/odeme-hatirlat',
    'created_at'                   => $attributes['created_at'] ?? $faker->iso8601,
    'updated_at'                   => $attributes['updated_at'] ?? $faker->iso8601,
]);

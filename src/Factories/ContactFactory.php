<?php

namespace TarfinLabs\Parasut\Factories;

use Faker\Generator as Faker;
use TarfinLabs\Parasut\Models\Contact;

/* @var $factory \Illuminate\Database\Eloquent\Factory */

$factory->define(Contact::class, function (Faker $faker) {
    return [
        'email'        => $faker->email,
        'name'         => $faker->name.' #TEST#',
        'short_name'   => null,
        'contact_type' => $faker->randomElement(['person', 'company']),
        'tax_office'   => "{$faker->city} Vergi Dairesi",
        'tax_number'   => $faker->numerify('###########'),
        'district'     => $faker->city,
        'city'         => $faker->city,
        'address'      => $faker->address,
        'phone'        => $faker->phoneNumber,
        'fax'          => $faker->phoneNumber,
        'is_abroad'    => $faker->boolean,
        'archived'     => $faker->boolean,
        'iban'         => null,
        'account_type' => $faker->randomElement(['customer', 'supplier']),
    ];
});

$factory->state(Contact::class, 'with-response', function (Faker $faker) {
    return [
        'balance'                      => $faker->randomFloat(4),
        'trl_balance'                  => $faker->randomFloat(4),
        'usd_balance'                  => $faker->randomFloat(4),
        'eur_balance'                  => $faker->randomFloat(4),
        'gbp_balance'                  => $faker->randomFloat(4),
        'term_days'                    => null,
        'invoicing_preferences'        => [],
        'sharings_count'               => 0,
        'ibans'                        => [],
        'exchange_rate_type'           => 'buying',
        'sharing_preview_url'          => "https://uygulama.parasut.com/{$faker->numberBetween(1000, 9999)}/portal/preview/{$faker->numberBetween(1000, 9999)}",
        'sharing_preview_path'         => "/{$faker->numberBetween(1000, 9999)}/portal/preview/{$faker->numberBetween(1000, 9999)}",
        'payment_reminder_preview_url' => "https://uygulama.parasut.com/{$faker->numberBetween(1000, 9999)}/portal/preview/{$faker->numberBetween(1000, 9999)}/odeme-hatirlat",
        'created_at'                   => $faker->iso8601,
        'updated_at'                   => $faker->iso8601,
    ];
});

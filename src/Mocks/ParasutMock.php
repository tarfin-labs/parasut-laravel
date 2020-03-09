<?php

namespace TarfinLabs\Parasut\Mocks;

use Faker\Factory;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class ParasutMock
{
    private static function getJsonContentType(): array
    {
        return ['content-type' => 'application/json; charset=utf-8'];
    }

    private static function getAuthenticationUrl(): string
    {
        return implode('/', [
            config('parasut.api_url'),
            config('parasut.token_url'),
        ]);
    }

    private static function getResourceUrl(string $resource): string
    {
        return implode('/', [
            config('parasut.api_url'),
            config('parasut.api_version'),
            config('parasut.company_id'),
            $resource,
        ]);
    }

    private static function generateMeta($faker, string $resource): array
    {
        return [
            'current_page' => $faker->numberBetween(1, 10),
            'total_pages'  => $faker->numberBetween(11, 100),
            'total_count'  => $faker->numberBetween(100, 1000),
            'per_page'     => $faker->numberBetween(1, 10),
            'export_url'   => "https://api.parasut.com/v4/{$faker->numberBetween(1000, 9999)}/{$resource}/export",
        ];
    }

    private static function generateLinks($faker, string $resource): array
    {
        return [
            'self' => "https://api.parasut.com/v4/141099/{$resource}?page%5Bnumber%5D={$faker->numberBetween(1, 10)}&page%5Bsize%5D={$faker->numberBetween(1, 10)}",
            'next' => "https://api.parasut.com/v4/141099/{$resource}?page%5Bnumber%5D={$faker->numberBetween(1, 10)}&page%5Bsize%5D={$faker->numberBetween(1, 10)}",
            'last' => "https://api.parasut.com/v4/141099/{$resource}?page%5Bnumber%5D={$faker->numberBetween(1, 10)}&page%5Bsize%5D={$faker->numberBetween(1, 10)}",
        ];
    }

    public static function fakeAuthentication(): void
    {
        Http::fake([
            self::getAuthenticationUrl() => Http::response(
                self::fakeAuthenticationResponse(),
                Response::HTTP_OK,
                self::getJsonContentType()
            ),
        ]);
    }

    private static function fakeAuthenticationResponse(): array
    {
        return [
            'access_token'  => 'fake-access-token',
            'token_type'    => 'bearer',
            'expires_in'    => 7200,
            'refresh_token' => 'fake-refresh-token',
            'scope'         => 'public',
            'created_at'    => 1583243989,
            'created_at'    => Carbon::now()->unix(),
        ];
    }

    public static function allContacts(int $count = 3): void
    {
        self::fakeAuthentication();

        Http::fake([
            self::getResourceUrl('contacts') => Http::response(
                self::allContactsResponse(),
                Response::HTTP_OK,
                self::getJsonContentType()
            ),
        ]);
    }

    private static function allContactsResponse(int $count = 3): array
    {
        $faker = Factory::create('tr_TR');

        $data = [];

        foreach (range(1, $count) as $index) {
            $data['data'][$index - 1] = [
                'id'            => $index,
                'type'          => 'contacts',
                'attributes'    => [
                    'created_at'                   => $faker->iso8601,
                    'updated_at'                   => $faker->iso8601,
                    'contact_type'                 => $faker->randomElement(['person', 'company']),
                    'name'                         => $faker->name,
                    'email'                        => $faker->email,
                    'short_name'                   => null,
                    'balance'                      => $faker->randomFloat(4),
                    'trl_balance'                  => $faker->randomFloat(4),
                    'usd_balance'                  => $faker->randomFloat(4),
                    'eur_balance'                  => $faker->randomFloat(4),
                    'gbp_balance'                  => $faker->randomFloat(4),
                    'tax_number'                   => $faker->numerify('###########'),
                    'tax_office'                   => "{$faker->city} Vergi Dairesi",
                    'archived'                     => $faker->boolean,
                    'account_type'                 => $faker->randomElement(['customer', 'supplier']),
                    'city'                         => $faker->city,
                    'district'                     => $faker->city,
                    'address'                      => $faker->address,
                    'phone'                        => $faker->phoneNumber,
                    'fax'                          => $faker->phoneNumber,
                    'is_abroad'                    => $faker->boolean,
                    'term_days'                    => null,
                    'invoicing_preferences'        => [],
                    'sharings_count'               => 0,
                    'ibans'                        => [],
                    'exchange_rate_type'           => 'buying',
                    'iban'                         => null,
                    'sharing_preview_url'          => "https://uygulama.parasut.com/{$faker->numberBetween(1000, 9999)}/portal/preview/{$faker->numberBetween(1000, 9999)}",
                    'sharing_preview_path'         => "/{$faker->numberBetween(1000, 9999)}/portal/preview/{$faker->numberBetween(1000, 9999)}",
                    'payment_reminder_preview_url' => "https://uygulama.parasut.com/{$faker->numberBetween(1000, 9999)}/portal/preview/{$faker->numberBetween(1000, 9999)}/odeme-hatirlat",
                ],
                'relationships' => [
                    'category'          => ['meta' => []],
                    'price_list'        => ['meta' => []],
                    'contact_portal'    => ['meta' => []],
                    'contact_people'    => ['meta' => []],
                    'activities'        => ['meta' => []],
                    'e_invoice_inboxes' => ['meta' => []],
                    'sharings'          => ['meta' => []],
                ],
                'meta'          => [
                    'created_at' => $faker->iso8601,
                    'updated_at' => $faker->iso8601,
                ],
            ];
        }

        $data['links'] = self::generateLinks($faker, 'contacts');
        $data['meta'] = self::generateMeta($faker, 'contacts');

        return $data;
    }
}
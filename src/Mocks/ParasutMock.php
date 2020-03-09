<?php

namespace TarfinLabs\Parasut\Mocks;

use Faker\Factory;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class ParasutMock
{
    public static function authentication(): void
    {
        Http::fake([
            config('parasut.api_url').'/'.config('parasut.token_url') => Http::response([
                'access_token'  => 'fake-access-token',
                'token_type'    => 'bearer',
                'expires_in'    => 7200,
                'refresh_token' => 'fake-refresh-token',
                'scope'         => 'public',
                'created_at'    => 1583243989,
                'created_at'    => Carbon::now()->unix(),
            ], Response::HTTP_OK, [
                'content-type' => 'application/json; charset=utf-8',
            ]),
        ]);
    }

    public static function contacts(int $count = 3): array
    {
        $faker = Factory::create('tr_TR');

        $data = [];

        foreach (range(1, $count) as $index) {
            $data['data'][$index - 1] =                 [
                'id'=> $index,
                'type' => 'contacts',
                'attributes' => '',
                'relationships' => '',
                'meta' => '',
            ];
        }

        $data['links'] = self::generateLinks($faker, 'contacts');
        $data['meta'] = self::generateMeta($faker, 'contacts');

        return $data;
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
}
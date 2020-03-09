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
}
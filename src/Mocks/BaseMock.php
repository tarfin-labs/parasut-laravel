<?php

namespace TarfinLabs\Parasut\Mocks;

use Faker\Factory;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use TarfinLabs\Parasut\Enums\ResourceNames;
use TarfinLabs\Parasut\Models\BaseModel;

abstract class BaseMock
{
    // region Abstract Functions

    abstract public static function all(int $count = 3): void;

    abstract public static function create(BaseModel $model): void;

    abstract public static function find(): int;

    abstract public static function update(BaseModel $model): void;

    abstract public static function delete(BaseModel $model): void;

    abstract public static function generateResponse(BaseModel $model = null): array;

    abstract public static function generateResponseMultiple(int $count = 3): array;

    abstract public static function getExtraMeta(): array;

    // endregion

    // region Helpers

    protected static function fakeHttp(string $resource, array $response, int $returnStatus): void
    {
        Http::fake([
            self::getResourceUrl($resource) => Http::response(
                $response,
                $returnStatus,
                self::getJsonContentType()
            ),
        ]);
    }

    protected static function getJsonContentType(): array
    {
        return ['content-type' => 'application/json; charset=utf-8'];
    }

    protected static function getAuthenticationUrl(): string
    {
        return ResourceNames::buildEndpoint(
            config('parasut.api_url'),
            config('parasut.token_url')
        );
    }

    protected static function getResourceUrl(string $resource): string
    {
        return ResourceNames::buildEndpoint(
            config('parasut.api_url'),
            config('parasut.api_version'),
            config('parasut.company_id'),
            $resource,
        );
    }

    protected static function generateMeta(string $resource, ?array $extraMeta = null): array
    {
        $faker = Factory::create('tr_TR');

        $meta = [
            'current_page' => $faker->numberBetween(1, 10),
            'total_pages'  => $faker->numberBetween(11, 100),
            'total_count'  => $faker->numberBetween(100, 1000),
            'per_page'     => $faker->numberBetween(1, 10),
            'export_url'   => "https://api.parasut.com/v4/{$faker->numberBetween(1000, 9999)}/{$resource}/export",
        ];

        return array_merge($meta, $extraMeta);
    }

    protected static function generateLinks(string $resource): array
    {
        $faker = Factory::create('tr_TR');

        return [
            'self' => "https://api.parasut.com/v4/141099/{$resource}?page%5Bnumber%5D={$faker->numberBetween(1, 10)}&page%5Bsize%5D={$faker->numberBetween(1, 10)}",
            'next' => "https://api.parasut.com/v4/141099/{$resource}?page%5Bnumber%5D={$faker->numberBetween(1, 10)}&page%5Bsize%5D={$faker->numberBetween(1, 10)}",
            'last' => "https://api.parasut.com/v4/141099/{$resource}?page%5Bnumber%5D={$faker->numberBetween(1, 10)}&page%5Bsize%5D={$faker->numberBetween(1, 10)}",
        ];
    }

    protected static function fakeAuthenticationResponse(): array
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

    protected static function getRelationships(): array
    {
        return [
            'category'          => ['meta' => []],
            'price_list'        => ['meta' => []],
            'contact_portal'    => ['meta' => []],
            'contact_people'    => ['meta' => []],
            'activities'        => ['meta' => []],
            'e_invoice_inboxes' => ['meta' => []],
            'sharings'          => ['meta' => []],
        ];
    }

    protected static function getMeta(BaseModel $model = null): array
    {
        $faker = Factory::create('tr_TR');

        return [
            'created_at' => $model->created_at ?? $faker->iso8601,
            'updated_at' => $model->updated_at ?? $faker->iso8601,
        ];
    }

    protected static function response(BaseModel $model = null, string $class, string $resource): array
    {
        $faker = Factory::create('tr_TR');

        $attributes = empty($model)
            ? factory($class)
                ->states(['creation', 'response'])
                ->raw()
            : $model->getAttributes();

        return [
            'data' => [
                'id'            => (string) $faker->numberBetween(10000, 99999),
                'type'          => $resource,
                'attributes'    => $attributes,
                'relationships' => self::getRelationships(),
                'meta'          => self::getMeta($model),
            ],
        ];
    }

    protected static function responseMultiple(int $count, string $class, string $resource, array $extraMeta): array
    {
        if ($count === 0)
        {
            return [
                'data' => [],
                'links' => [],
                'meta' => [],
            ];
        }

        $data = [];

        foreach (range(1, $count) as $index) {
            $data['data'][$index - 1] = [
                'id'            => $index,
                'type'          => $resource,
                'attributes'    => factory($class)->states(['creation', 'response'])->raw(),
                'relationships' => self::getRelationships(),
                'meta'          => self::getMeta(),
            ];
        }

        $data['links'] = self::generateLinks($resource);
        $data['meta'] = self::generateMeta($resource, $extraMeta);

        return $data;
    }

    // endregion

    // region Public Functions

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

    // endregion
}

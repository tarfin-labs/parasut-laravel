<?php

namespace TarfinLabs\Parasut\Mocks;

use Faker\Factory;
use Illuminate\Http\Response;
use TarfinLabs\Parasut\Models\BaseModel;
use TarfinLabs\Parasut\Models\Product;
use TarfinLabs\Parasut\Enums\ResourceNames;

class ProductMock extends BaseMock
{
    public static function all(int $count = 3): void
    {
        self::fakeAuthentication();

        $response = self::generateResponseMultiple();

        self::fakeHttp(
            ResourceNames::PRODUCT,
            $response,
            Response::HTTP_OK
        );
    }

    public static function create(BaseModel $product): void
    {
        self::fakeAuthentication();

        self::fakeHttp(
            ResourceNames::PRODUCT,
            self::generateResponse($product),
            Response::HTTP_OK
        );
    }

    public static function find(): int
    {
        self::fakeAuthentication();

        $response = self::generateResponse();

        self::fakeHttp(
            'products/'.$response['data']['id'],
            $response,
            Response::HTTP_OK
        );

        return $response['data']['id'];
    }

    public static function update(BaseModel $product): void
    {
        self::fakeAuthentication();

        self::fakeHttp(
            ResourceNames::PRODUCT.'/'.$product->id,
            self::generateResponse($product),
            Response::HTTP_OK
        );
    }

    public static function delete(BaseModel $product): void
    {
        self::fakeAuthentication();

        self::fakeHttp(
            ResourceNames::PRODUCT.'/'.$product->id,
            [[]],
            Response::HTTP_OK
        );
    }

    public static function generateResponse(BaseModel $model = null): array
    {
        return self::response($model, Product::class, ResourceNames::PRODUCT);
    }

    public static function generateResponseMultiple(int $count = 3): array
    {
        return self::responseMultiple($count, Product::class, ResourceNames::PRODUCT, self::getExtraMeta());
    }

    public static function getExtraMeta(): array
    {
        $faker = Factory::create('tr_TR');

        return [
            'payable_total' => $faker->randomFloat(2, 100, 1000),
            'collectible_total' => $faker->randomFloat(2, 100, 1000),
        ];
    }
}

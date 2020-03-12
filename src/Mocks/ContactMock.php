<?php

namespace TarfinLabs\Parasut\Mocks;

use Faker\Factory;
use Illuminate\Http\Response;
use TarfinLabs\Parasut\Models\BaseModel;
use TarfinLabs\Parasut\Models\Contact;
use TarfinLabs\Parasut\Enums\ResourceNames;

class ContactMock extends BaseMock
{
    public static function all(int $count = 3): void
    {
        self::fakeAuthentication();

        $response = self::generateResponseMultiple();

        self::fakeHttp(
            ResourceNames::CONTACT,
            $response,
            Response::HTTP_OK
        );
    }

    public static function create(BaseModel $contact): void
    {
        self::fakeAuthentication();

        self::fakeHttp(
            ResourceNames::CONTACT,
            self::generateResponse($contact),
            Response::HTTP_OK
        );
    }

    public static function find(): int
    {
        self::fakeAuthentication();

        $response = self::generateResponse();

        self::fakeHttp(
            'contacts/'.$response['data']['id'],
            $response,
            Response::HTTP_OK
        );

        return $response['data']['id'];
    }

    public static function update(BaseModel $contact): void
    {
        self::fakeAuthentication();

        self::fakeHttp(
            ResourceNames::CONTACT.'/'.$contact->id,
            self::generateResponse($contact),
            Response::HTTP_OK
        );
    }

    public static function delete(BaseModel $contact): void
    {
        self::fakeAuthentication();

        self::fakeHttp(
            ResourceNames::CONTACT.'/'.$contact->id,
            [[]],
            Response::HTTP_OK
        );
    }

    public static function generateResponse(BaseModel $model = null): array
    {
        return self::response($model, Contact::class, ResourceNames::CONTACT);
    }

    public static function generateResponseMultiple(int $count = 3): array
    {
        return self::responseMultiple($count, Contact::class, ResourceNames::CONTACT, self::getExtraMeta());
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

<?php

namespace TarfinLabs\Parasut\Tests\Mocks;

use Illuminate\Http\Response;
use TarfinLabs\Parasut\Models\Contact;
use TarfinLabs\Parasut\Models\BaseModel;

class ContactMock extends BaseMock
{
    public static function all(int $count = 3): void
    {
        self::fakeAuthentication();

        $response = self::generateResponseMultiple();

        self::fakeHttp(
            'contacts',
            $response,
            Response::HTTP_OK
        );
    }

    public static function create(BaseModel $contact): void
    {
        self::fakeAuthentication();

        self::fakeHttp(
            'contacts',
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

    public static function update(Contact $contact): void
    {
        self::fakeAuthentication();

        self::fakeHttp(
            'contacts'.'/'.$contact->id,
            self::generateResponse($contact),
            Response::HTTP_OK
        );
    }

    public static function delete(Contact $contact): void
    {
        self::fakeAuthentication();

        self::fakeHttp(
            'contacts'.'/'.$contact->id,
            [[]],
            Response::HTTP_OK
        );
    }

    public static function generateResponse(BaseModel $model = null): array
    {
        return self::response($model, Contact::class, 'contacts');
    }

    public static function generateResponseMultiple(int $count = 3): array
    {
        return self::responseMultiple($count, Contact::class, 'contacts');
    }
}

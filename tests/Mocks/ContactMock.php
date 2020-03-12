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

        $response = self::allContactsResponse();

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
            self::createContactResponse($contact),
            Response::HTTP_OK
        );
    }

    public static function find(): int
    {
        self::fakeAuthentication();

        $response = self::createContactResponse();

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
            self::createContactResponse($contact),
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
}

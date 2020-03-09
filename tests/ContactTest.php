<?php

namespace TarfinLabs\Parasut\Tests;

use Orchestra\Testbench\TestCase;
use TarfinLabs\Parasut\Models\Contact;
use TarfinLabs\Parasut\Mocks\ParasutMock;
use TarfinLabs\Parasut\ParasutServiceProvider;
use TarfinLabs\Parasut\Repositories\ContactRepository;

class ContactTest extends TestCase
{

    protected function getPackageProviders($app): array
    {
        return [ParasutServiceProvider::class];
    }

    /** @test */
    public function user_can_list_contacts(): void
    {
        ParasutMock::allContacts();

        $contactRepository = new ContactRepository();

        $contacts = $contactRepository->all();

        $this->assertNotNull(Contact::all());
        $this->assertInstanceOf(Contact::class, $contacts->first());
    }
}

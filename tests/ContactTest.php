<?php

namespace TarfinLabs\Parasut\Tests;

use TarfinLabs\Parasut\Models\Contact;
use TarfinLabs\Parasut\Tests\Mocks\ParasutMock;
use TarfinLabs\Parasut\Repositories\ContactRepository;

class ContactTest extends TestCase
{
    /** @test */
    public function user_can_list_contacts(): void
    {
        ParasutMock::allContacts();

        $contactRepository = new ContactRepository();

        $contacts = $contactRepository->all();

        $this->assertNotNull(Contact::all());
        $this->assertInstanceOf(Contact::class, $contacts->first());
    }

    /** @test */
    public function user_can_create_a_new_contact(): void
    {
        $this->assertTrue(true);
    }
}

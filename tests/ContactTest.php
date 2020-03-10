<?php

namespace TarfinLabs\Parasut\Tests;

use Faker\Factory;
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
        $faker = Factory::create('tr_TR');

        $contact = new Contact();
        $contact->name = '#TESTX# '.$faker->name;
        $contact->account_type = $faker->randomElement(['customer', 'supplier']);

        ParasutMock::createContact($contact);

        $contactRepository = new ContactRepository();

        $contactReturned = $contactRepository->create($contact);

        $this->assertInstanceOf(
            Contact::class,
            $contact
        );

        $this->assertEquals(
            $contact->name,
            $contactReturned->name
        );
    }

    /** @test */
    public function user_can_view_a_contact(): void
    {
        $contactId = ParasutMock::findContact();

        $contactRepository = new ContactRepository();

        $contact = $contactRepository->find($contactId);

        $this->assertInstanceOf(
            Contact::class,
            $contact
        );

        $this->assertEquals(
            $contactId,
            $contact->id
        );
    }
}

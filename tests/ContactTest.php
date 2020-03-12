<?php

namespace TarfinLabs\Parasut\Tests;

use TarfinLabs\Parasut\Models\Contact;
use TarfinLabs\Parasut\Repositories\ContactRepository;
use TarfinLabs\Parasut\Tests\Mocks\ParasutMock;

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
        $contact = factory(Contact::class)->make();

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

    /** @test */
    public function user_can_edit_a_contact(): void
    {
        $contact = factory(Contact::class)->make();

        ParasutMock::createContact($contact);
        $contactRepository = new ContactRepository();
        $contact = $contactRepository->create($contact);

        $newContact = factory(Contact::class)->make();
        $newContact->id = $contact->id;

        ParasutMock::updateContact($contact);
        $updatedContact = $contactRepository->update($newContact);

        $this->assertInstanceOf(
            Contact::class,
            $updatedContact
        );

        $this->assertEquals(
            $updatedContact->name,
            $newContact->name
        );
    }

    /** @test */
    public function user_can_delete_a_contact(): void
    {
        $contact = factory(Contact::class)->make();

        ParasutMock::createContact($contact);
        $contactRepository = new ContactRepository();
        $contact = $contactRepository->create($contact);

        ParasutMock::deleteContact($contact);
        $result = $contactRepository->delete($contact);

        $this->assertTrue($result);
    }
}

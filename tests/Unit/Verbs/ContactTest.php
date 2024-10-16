<?php

use App\Events\ContactCreated;
use App\Events\ContactEmailAdded;
use App\Events\ContactEmailRemoved;
use App\Events\ContactFolderChanged;
use App\Events\ContactTransferred;
use App\Events\ContactUpdatedFirstName;
use App\Events\ContactUpdatedLastName;
use App\Models\User;
use App\States\ContactState;
use Carbon\CarbonImmutable;
use Thunk\Verbs\Exceptions\EventNotValidForCurrentState;

beforeAll(function () {
    CarbonImmutable::setTestNow('2024-10-01 11:00:00');
});

test('that a contact can be created', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $contact_id = snowflake_id();

    ContactState::factory()->create([
        'id' => $contact_id,
    ]);
    ContactCreated::fire(contact_id: $contact_id, owner_id: $user->id, created_at: CarbonImmutable::now());
    $contact_state = ContactState::load($contact_id);
    $this->assertSame($user->id, $contact_state->getOwnerId());
});

test('that a contact can have a name and folder', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $contact_id = snowflake_id();
    ContactState::factory()->create([
        'id' => $contact_id,
    ]);
    ContactCreated::fire(contact_id: $contact_id, owner_id: $user->id, created_at: CarbonImmutable::now());
    ContactUpdatedFirstName::fire(contact_id: $contact_id, first_name: 'John');
    ContactUpdatedLastName::fire(contact_id: $contact_id, last_name: 'Doe');
    ContactFolderChanged::fire(contact_id: $contact_id, folder: 'Friends');

    $contact_state = ContactState::load($contact_id);
    $this->assertSame('John', $contact_state->getFirstName());
    $this->assertSame('Doe', $contact_state->getLastName());
    $this->assertSame('Friends', $contact_state->getFolder());
});

test('that a contact can have zero or more email address', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $contact_id = snowflake_id();
    ContactState::factory()->create([
        'id' => $contact_id,
    ]);
    ContactCreated::fire(contact_id: $contact_id, owner_id: $user->id, created_at: CarbonImmutable::now());
    $contact_state = ContactState::load($contact_id);

    $this->assertEmpty($contact_state->emails);

    ContactEmailAdded::fire(contact_id: $contact_id, email: 'test1@gmail.com');

    $contact_state = ContactState::load($contact_id);
    $this->assertSame(['test1@gmail.com'], $contact_state->emails);

    ContactEmailAdded::fire(contact_id: $contact_id, email: 'test2@gmail.com');

    $contact_state = ContactState::load($contact_id);
    $this->assertSame(['test1@gmail.com', 'test2@gmail.com'], $contact_state->emails);

    ContactEmailRemoved::fire(contact_id: $contact_id, email: 'test1@gmail.com');
    $contact_state = ContactState::load($contact_id);
    $this->assertSame(['test2@gmail.com'], $contact_state->emails);
});

test('that an invalid email address will be rejected', function () {
    $this->expectException(EventNotValidForCurrentState::class);

    $user = User::factory()->create();
    $this->actingAs($user);
    $contact_id = snowflake_id();
    ContactState::factory()->create([
        'id' => $contact_id,
    ]);
    ContactCreated::fire(contact_id: $contact_id, owner_id: $user->id, created_at: CarbonImmutable::now());
    $contact_state = ContactState::load($contact_id);

    $this->assertEmpty($contact_state->emails);

    ContactEmailAdded::fire(contact_id: $contact_id, email: 'INVALID_EMAIL');
});

test('that a contact can be transferred to another user', function () {
    $original_owner = User::factory()->create();
    $transferred_to = User::factory()->create();

    $this->actingAs($original_owner);
    $contact_id = snowflake_id();
    ContactState::factory()->create([
        'id' => $contact_id,
    ]);
    ContactCreated::fire(contact_id: $contact_id, owner_id: $original_owner->id, created_at: CarbonImmutable::now());
    ContactTransferred::fire(contact_id: $contact_id, transferred_to: $transferred_to->id);

    $contact_state = ContactState::load($contact_id);
    $this->assertSame($transferred_to->id, $contact_state->getOwnerId());
});

test('that only the owner can transfer the contact', function () {
    $this->expectException(Exception::class);

    $owner = User::factory()->create();
    $logged_in_user = User::factory()->create();

    $this->actingAs($owner);
    $contact_id = snowflake_id();
    ContactState::factory()->create([
        'id' => $contact_id,
    ]);
    ContactCreated::fire(contact_id: $contact_id, owner_id: $owner->id, created_at: CarbonImmutable::now());

    $this->actingAs($logged_in_user);
    ContactTransferred::fire(contact_id: $contact_id, transferred_to: $logged_in_user->id);
});

test('that only the owner can update the contact\'s first name', function () {
    $this->expectException(Exception::class);

    $owner = User::factory()->create();
    $logged_in_user = User::factory()->create();

    $this->actingAs($owner);
    $contact_id = snowflake_id();
    ContactState::factory()->create([
        'id' => $contact_id,
    ]);
    ContactCreated::fire(contact_id: $contact_id, owner_id: $owner->id, created_at: CarbonImmutable::now());

    $this->actingAs($logged_in_user);
    ContactUpdatedFirstName::fire(contact_id: $contact_id, first_name: 'Eric');
});

test('that only the owner can update the contact\'s last name', function () {
    $this->expectException(Exception::class);

    $owner = User::factory()->create();
    $logged_in_user = User::factory()->create();

    $this->actingAs($owner);
    $contact_id = snowflake_id();
    ContactState::factory()->create([
        'id' => $contact_id,
    ]);
    ContactCreated::fire(contact_id: $contact_id, owner_id: $owner->id, created_at: CarbonImmutable::now());

    $this->actingAs($logged_in_user);
    ContactUpdatedLastName::fire(contact_id: $contact_id, last_name: 'Johnson');
});


<?php

namespace App\Events;

use App\Models\Contact;
use App\States\ContactState;
use Thunk\Verbs\Attributes\Autodiscovery\StateId;
use Thunk\Verbs\Event;

class ContactUpdatedName extends Event
{
    use ValidateOwnerAccess;

    #[StateId(ContactState::class)]
    public int $contact_id;

    public string $first_name;
    public string $last_name;

    public function apply(ContactState $state): void
    {
        $state->setFirstName($this->first_name);
        $state->setLastName($this->last_name);
    }

    public function handle(ContactState $state): void
    {
        $contact = Contact::find($this->contact_id);
        $contact->first_name = $this->first_name;
        $contact->last_name = $this->last_name;
        $contact->save();
    }
}

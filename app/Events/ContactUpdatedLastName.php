<?php

namespace App\Events;

use App\Models\Contact;
use App\States\ContactState;
use Thunk\Verbs\Attributes\Autodiscovery\StateId;
use Thunk\Verbs\Event;

class ContactUpdatedLastName extends Event
{
    use ValidateOwnerAccess;

    #[StateId(ContactState::class)]
    public int $contact_id;

    public string $last_name;

    public function apply(ContactState $state): void
    {
        $state->setLastName($this->last_name);

        $contact = Contact::find($this->contact_id);
        $contact->last_name = $this->last_name;
        $contact->save();
    }
}

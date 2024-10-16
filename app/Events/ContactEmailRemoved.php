<?php

namespace App\Events;

use App\States\ContactState;
use Thunk\Verbs\Attributes\Autodiscovery\StateId;
use Thunk\Verbs\Event;

class ContactEmailRemoved extends Event
{
    use ValidateOwnerAccess;

    #[StateId(ContactState::class)]
    public int $contact_id;

    public string $email;

    public function validate(ContactState $state): void
    {
        $this->assert(in_array($this->email, $state->emails), 'Email not found');
    }

    public function apply(ContactState $state): void
    {
        $state->removedEmail($this->email);
    }
}

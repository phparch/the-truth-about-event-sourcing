<?php

namespace App\Events;

use App\States\ContactState;
use Thunk\Verbs\Attributes\Autodiscovery\StateId;
use Thunk\Verbs\Event;
use Thunk\Verbs\Facades\Verbs;

class ContactEmailAdded extends Event
{
    use ValidateOwnerAccess;

    #[StateId(ContactState::class)]
    public int $contact_id;

    public string $email;

    public function validate(): void
    {
        $this->assert(filter_var($this->email, FILTER_VALIDATE_EMAIL), 'Invalid Email');
    }

    public function apply(ContactState $state): void
    {
        Verbs::unlessReplaying(function () {
            // Send email to the contact based on some logic
        });
        $state->addEmail($this->email);
    }
}

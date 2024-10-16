<?php

namespace App\Events;

use App\States\ContactState;
use Thunk\Verbs\Attributes\Autodiscovery\StateId;
use Thunk\Verbs\Event;

class ContactTransferred extends Event
{
    use ValidateOwnerAccess;

    #[StateId(ContactState::class)]
    public int $contact_id;

    public int $transferred_to;

    public function apply(ContactState $state): void
    {
        $state->setOwnerId($this->transferred_to);
    }
}

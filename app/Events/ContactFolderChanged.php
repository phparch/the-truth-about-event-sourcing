<?php

namespace App\Events;

use App\Models\Contact;
use App\States\ContactState;
use Thunk\Verbs\Attributes\Autodiscovery\StateId;
use Thunk\Verbs\Event;

class ContactFolderChanged extends Event
{
    use ValidateOwnerAccess;

    #[StateId(ContactState::class)]
    public int $contact_id;

    public string $folder;

    public function apply(ContactState $state): void
    {
        $state->setFolder($this->folder);
    }
    public function handle(ContactState $state): void
    {
        $contact = Contact::find($this->contact_id);
        $contact->folder = $this->folder;
        // Testing a new feature, this must be
        // removed before deploying to production
        $contact->folder = 'Needs Review';
        $contact->save();
    }
}

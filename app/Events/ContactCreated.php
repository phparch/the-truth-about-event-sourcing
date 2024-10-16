<?php

namespace App\Events;

use App\Models\Contact;
use App\States\ContactState;
use Carbon\CarbonImmutable;
use Thunk\Verbs\Attributes\Autodiscovery\StateId;
use Thunk\Verbs\Event;

class ContactCreated extends Event
{
    #[StateId(ContactState::class)]
    public int $contact_id;

    public int $owner_id;
    public CarbonImmutable $created_at;

    public function __construct(int $contact_id, int $owner_id, CarbonImmutable $created_at)
    {
        $this->contact_id = $contact_id;
        $this->owner_id = $owner_id;
        $this->created_at = $created_at ?? CarbonImmutable::now();
    }

    public function validate(ContactState $state): void
    {
        if ($state->hasOwnerId()) {
            throw new \Exception('Contact already exists');
        }
    }

    public function apply(ContactState $state): void
    {
        $state->setOwnerId($this->owner_id);
        $state->setCreatedAt($this->created_at);

        Contact::factory()->create([
            'id' => $this->contact_id,
            'owner_id' => $this->owner_id,
            'created_at' => $this->created_at,
            'folder' => '',
            'first_name' => '',
            'last_name' => '',
        ]);
    }
}

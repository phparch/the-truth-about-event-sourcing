<?php
declare(strict_types=1);

namespace App\EventSauce\Command;

use App\EventSauce\Contact;
use App\EventSauce\ContactId;
use App\EventSauce\Events\ContactCreated;
use Carbon\CarbonImmutable;

class CreateNewContact implements ContactCommand
{
    public function __construct(
        public ContactId $contact_id,
        public int $owner_id,
        public CarbonImmutable $created_at
    ) {
    }

    public function execute(Contact $contact): array
    {
        return [
            new ContactCreated(
                $this->contact_id,
                $this->owner_id,
                $this->created_at,
            )
        ];
    }
}

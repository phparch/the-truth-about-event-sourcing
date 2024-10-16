<?php
declare(strict_types=1);

namespace App\EventSauce\Command;

use App\EventSauce\Contact;
use App\EventSauce\ContactId;
use App\EventSauce\Events\ContactCreated;
use App\EventSauce\Events\FirstNameWasSet;
use App\EventSauce\Events\LastNameWasSet;
use Carbon\CarbonImmutable;

class SetLastName implements ContactCommand
{
    public function __construct(
        public readonly string $last_name,
    ) {
    }

    public function execute(Contact $contact): array
    {
        return [
            new LastNameWasSet($this->last_name),
        ];
    }
}

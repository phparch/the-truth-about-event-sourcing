<?php
declare(strict_types=1);

namespace App\EventSauce\Command;

use App\EventSauce\Contact;
use App\EventSauce\ContactId;
use App\EventSauce\Events\ContactCreated;
use App\EventSauce\Events\FirstNameWasSet;
use Carbon\CarbonImmutable;

class SetFirstName implements ContactCommand
{
    public function __construct(
        public readonly string $first_name,
    ) {
    }

    public function execute(Contact $contact): array
    {
        return [
            new FirstNameWasSet($this->first_name),
        ];
    }
}

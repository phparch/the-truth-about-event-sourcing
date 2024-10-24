<?php
declare(strict_types=1);

namespace App\EventSauce\Command;

use App\EventSauce\Contact;
use App\EventSauce\ContactId;
use App\EventSauce\Events\ContactWasCreated;
use App\EventSauce\Events\FirstNameWasSet;
use App\EventSauce\Events\LastNameWasSet;
use Carbon\CarbonImmutable;

class SetName implements ContactCommand
{
    public function __construct(
        public readonly string $first_name,
        public readonly string $last_name,
    ) {
    }

    public function execute(Contact $contact): array
    {
        return [
            new FirstNameWasSet($this->first_name),
            new LastNameWasSet($this->last_name),
        ];
    }
}

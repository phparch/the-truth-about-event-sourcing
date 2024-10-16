<?php
declare(strict_types=1);


namespace App\Events;

use App\States\ContactState;

trait ValidateOwnerAccess
{
    public function validate(ContactState $state): void
    {
        if ($state->getOwnerId() !== auth()->id()) {
            throw new \Exception('You do not have access to this contact ' . $state->getOwnerId() . '-'. auth()->id());
        }
    }
}

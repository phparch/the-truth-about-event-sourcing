<?php
declare(strict_types=1);

namespace App\EventSauce\Command;

use App\EventSauce\Contact;
use App\EventSauce\ContactId;
use App\EventSauce\Events\ContactWasCreated;
use App\EventSauce\Events\FirstNameWasSet;
use App\EventSauce\Events\FolderWasChanged;
use App\EventSauce\Events\LastNameWasSet;
use Carbon\CarbonImmutable;

class ChangeFolder implements ContactCommand
{
    public function __construct(
        public readonly string $folder,
    ) {
    }

    public function execute(Contact $contact): array
    {
        return [
            new FolderWasChanged($this->folder),
        ];
    }
}

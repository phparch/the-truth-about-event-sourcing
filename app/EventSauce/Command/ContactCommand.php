<?php
declare(strict_types=1);


namespace App\EventSauce\Command;

use App\EventSauce\Contact;

interface ContactCommand
{
    public function execute(Contact $contact): array;
}

<?php
declare(strict_types=1);

namespace App\EventSauce;

use App\EventSauce\Command\ContactCommand;
use App\EventSauce\Command\CreateNewContact;
use App\EventSauce\Events\ContactCreated;
use App\EventSauce\Events\FirstNameWasSet;
use App\EventSauce\Events\LastNameWasSet;
use Carbon\CarbonImmutable;
use EventSauce\EventSourcing\AggregateRoot;
use EventSauce\EventSourcing\AggregateRootBehaviour;

class Contact implements AggregateRoot
{
    use AggregateRootBehaviour;

    private int $owner_id;
    private CarbonImmutable $created_at;
    private string $first_name;
    private string $last_name;

    public static function make(ContactId $id, int $owner_id, CarbonImmutable|null $created_when): Contact
    {
        $created_when ??= CarbonImmutable::now();
        $contact = new self($id);
        $contact->recordThat(new ContactCreated($id, $owner_id, $created_when));

        return $contact;
    }

    public function process(ContactCommand $command): void
    {
        $this->guardCommands($command);

        $events = $command->execute($this);

        foreach ($events as $event) {
            $this->recordThat($event);
        }
    }

    public function applyContactCreated(ContactCreated $event): void
    {
        $this->owner_id = $event->owner_id;
        $this->created_at = $event->created_at;
    }

    public function applyFirstNameWasSet(FirstNameWasSet $event): void
    {
        $this->first_name = $event->first_name;
    }

    public function applyLastNameWasSet(LastNameWasSet $event): void
    {
        $this->last_name = $event->last_name;
    }

    private function guardCommands(ContactCommand $command)
    {
        $this->contactMustBeCreated($command);
        $this->contactMustBeOwnedByCurrentUser($command);
    }

    private function contactMustBeCreated(ContactCommand $command)
    {
        if ($command instanceof CreateNewContact && $this->aggregateRootVersion() === 0) {
            return;
        }

        if ($command instanceof CreateNewContact && $this->aggregateRootVersion() > 0) {
            throw new \Exception('Contact already created');
        }

        if ($this->aggregateRootVersion() === 0) {
            throw new \Exception('First command must be CreateNewContact');
        }
    }

    public function getFirstName(): string
    {
        return $this->first_name;
    }

    public function getLastName(): string
    {
        return $this->last_name;
    }

    public function hasOwnerId(): false
    {
        return false;
    }

    public function getFolder(): string
    {
        return 'not defined';
    }

    public function getEmails(): array
    {
        return [];
    }

    private function contactMustBeOwnedByCurrentUser(ContactCommand $command)
    {
        //Todo: implement
    }
}

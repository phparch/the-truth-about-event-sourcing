<?php
declare(strict_types=1);


namespace App\EventSauce\Consumer;

use App\EventSauce\Events\ContactWasCreated;
use App\EventSauce\Events\FirstNameWasSet;
use App\EventSauce\Events\FolderWasChanged;
use App\EventSauce\Events\LastNameWasSet;
use App\Models\ContactSearch;
use EventSauce\EventSourcing\Message;
use EventSauce\EventSourcing\MessageConsumer;

class ContactSearchConsumer implements MessageConsumer
{
    public function handleContactWasCreated(ContactWasCreated $event): void
    {
        ContactSearch::factory()->create([
            'id' => $event->contact_id->toString(),
            'owner_id' => $event->owner_id,
            'created_at' => $event->created_at,
            'folder' => '',
            'first_name' => '',
            'last_name' => '',
        ]);
    }

    public function handleFirstNameWasSet(FirstNameWasSet $event, Message $message): void
    {
        $contact = ContactSearch::find($message->aggregateRootId()->toString());
        $contact->first_name = $event->first_name;
        $contact->save();
    }

    public function handleLastNameWasSet(LastNameWasSet $event, Message $message): void
    {
        $contact = ContactSearch::find($message->aggregateRootId()->toString());
        $contact->last_name = $event->last_name;
        $contact->save();
    }

    public function handleFolderWasChanged(FolderWasChanged $event, Message $message): void
    {
        $contact = ContactSearch::find($message->aggregateRootId()->toString());
        $contact->folder = $event->folder;
        $contact->save();
    }

    public function handle(Message $message): void
    {
        $event = $message->payload();

        match (get_class($event)) {
            ContactWasCreated::class => $this->handleContactWasCreated($event),
            FirstNameWasSet::class => $this->handleFirstNameWasSet($event, $message),
            LastNameWasSet::class => $this->handleLastNameWasSet($event, $message),
            FolderWasChanged::class => $this->handleFolderWasChanged($event, $message),
        };
    }
}

<?php
declare(strict_types=1);


namespace Tests\Unit\EventSauce;

use App\EventSauce\Command\ContactCommand;
use App\EventSauce\Contact;
use App\EventSauce\ContactId;
use App\EventSauce\Events\ContactCreated;
use Carbon\CarbonImmutable;
use EventSauce\EventSourcing\AggregateRootId;
use EventSauce\EventSourcing\TestUtilities\AggregateRootTestCase;
use PHPUnit\Framework\Attributes\Before;

class ContactAggregateTestCase extends AggregateRootTestCase
{

    public const ID = '1';
    public const OWNER_ID = 100;
    public const CREATED_WHEN = '2024-10-01 12:00:00';
    private static Contact $contact_created;

    #[Before]
    public static function setupEventsForTests(): void
    {
        $contact_id = ContactId::fromString(self::ID);
        self::$contact_created = Contact::make($contact_id, self::OWNER_ID, new CarbonImmutable(self::CREATED_WHEN));
    }

    protected function newAggregateRootId(): AggregateRootId
    {
        return ContactId::fromString(self::ID);
    }

    protected function aggregateRootClassName(): string
    {
        return Contact::class;
    }

    protected function handle(ContactCommand ...$commands): void
    {
        $contact = $this->repository->retrieve($this->aggregateRootId());

        foreach ($commands as $command) {
            $contact->process($command);
        }

        $this->repository->persist($contact);
    }
}

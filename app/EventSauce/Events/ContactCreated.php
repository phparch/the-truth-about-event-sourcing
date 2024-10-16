<?php
declare(strict_types=1);


namespace App\EventSauce\Events;

use App\EventSauce\ContactId;
use Carbon\CarbonImmutable;
use EventSauce\EventSourcing\Serialization\SerializablePayload;

class ContactCreated implements ContactEvent, SerializablePayload
{
    public function __construct(public readonly ContactId $contact_id, public readonly int $owner_id, public readonly CarbonImmutable $created_at)
    {
    }

    public function toPayload(): array
    {
        return [
            'contact_id' => $this->contact_id->toString(),
            'owner_id' => $this->owner_id,
            'created_at' => $this->created_at->serialize(),
        ];
    }

    public static function fromPayload(array $payload): static
    {
        return new self(
            ContactId::fromString($payload['contact_id']),
            $payload['owner_id'],
            CarbonImmutable::fromSerialized($payload['created_at'])
        );
    }
}

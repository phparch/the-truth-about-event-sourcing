<?php
declare(strict_types=1);

namespace App\EventSauce\Events;

use EventSauce\EventSourcing\Serialization\SerializablePayload;

class LastNameWasSet implements ContactEvent, SerializablePayload
{
    public function __construct(public readonly string $last_name)
    {
    }

    public function toPayload(): array
    {
        return [
            'last_name' => $this->last_name,
        ];
    }

    public static function fromPayload(array $payload): static
    {
        return new self(
            $payload['last_name'],
        );
    }
}

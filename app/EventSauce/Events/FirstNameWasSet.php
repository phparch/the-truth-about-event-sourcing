<?php
declare(strict_types=1);

namespace App\EventSauce\Events;

use EventSauce\EventSourcing\Serialization\SerializablePayload;

class FirstNameWasSet implements ContactEvent, SerializablePayload
{
    public function __construct(public readonly string $first_name)
    {
    }

    public function toPayload(): array
    {
        return [
            'first_name' => $this->first_name,
        ];
    }

    public static function fromPayload(array $payload): static
    {
        return new self(
            $payload['first_name'],
        );
    }
}

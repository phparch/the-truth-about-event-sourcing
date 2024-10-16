<?php
declare(strict_types=1);


namespace App\EventSauce;

use EventSauce\EventSourcing\AggregateRootId;

class ContactId implements AggregateRootId
{
    private function __construct(private int $id) {}

    public function toString(): string
    {
        return (string) $this->id;
    }

    public static function fromString(string $id): static
    {
        return new self((int) $id);
    }
}

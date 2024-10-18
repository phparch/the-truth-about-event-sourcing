<?php
declare(strict_types=1);

namespace App\EventSauce\Events;

use EventSauce\EventSourcing\Serialization\SerializablePayload;

class FolderWasChanged implements ContactEvent, SerializablePayload
{
    public function __construct(public readonly string $folder)
    {
    }

    public function toPayload(): array
    {
        return [
            'folder' => $this->folder,
        ];
    }

    public static function fromPayload(array $payload): static
    {
        return new self(
            $payload['folder'],
        );
    }
}

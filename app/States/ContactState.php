<?php

namespace App\States;

use Thunk\Verbs\State;

class ContactState extends State
{
    public \DateTimeImmutable|null $created_at = null;

    public string $first_name;
    public string $last_name;

    public string $folder = 'not_set';
    public int $owner_id;

    public array $emails = [];

    public function getFirstName(): string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): void
    {
        $this->first_name = $first_name;
    }

    public function getLastName(): string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): void
    {
        $this->last_name = $last_name;
    }

    public function getFolder(): string
    {
        return $this->folder;
    }

    public function setFolder(string $folder): void
    {
        $this->folder = $folder;
    }

    public function getOwnerId(): int
    {
        return $this->owner_id;
    }

    public function hasOwnerId(): bool
    {
        return isset($this->owner_id);
    }

    public function setOwnerId(int $owner_id): void
    {
        $this->owner_id = $owner_id;
    }

    public function getCreatedAt(): \DateTimeImmutable|null
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): void
    {
        $this->created_at = $created_at;
    }

    public function addEmail(string $email)
    {
        $this->emails[] = $email;
    }

    public function removedEmail(string $email)
    {
        $this->emails = array_values(array_filter($this->emails, fn($e) => $e !== $email));
    }

    public function getEmails(): array
    {
        return $this->emails;
    }
}

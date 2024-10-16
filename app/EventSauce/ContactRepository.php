<?php
declare(strict_types=1);


namespace App\EventSauce;

use EventSauce\EventSourcing\AggregateRootId;
use EventSauce\EventSourcing\AggregateRootRepository;

class ContactRepository
{
    public function __construct(
        private readonly AggregateRootRepository $repository,
    ) {}

    public function retrieve(AggregateRootId $id): object
    {
        return $this->repository->retrieve($id);
    }

    public function persist(object $object): void
    {
        $this->repository->persist($object);
    }

    public function getWrappedRepository(): AggregateRootRepository
    {
        return $this->repository;
    }
}

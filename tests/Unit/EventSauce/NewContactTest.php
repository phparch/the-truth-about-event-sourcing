<?php
declare(strict_types=1);

namespace Tests\Unit\EventSauce;

use App\EventSauce\Command\CreateNewContact;
use App\EventSauce\Command\SetFirstName;
use App\EventSauce\Command\SetLastName;
use App\EventSauce\Events\ContactCreated;
use Carbon\CarbonImmutable;
use PHPUnit\Framework\Attributes\IgnoreDeprecations;
use PHPUnit\Framework\Attributes\Test;

#[IgnoreDeprecations]
class NewContactTest extends ContactAggregateTestCase
{
    #[Test]
    public function make_returns_new_aggregate_and_expected_and_default_values(): void
    {
        $id = $this->aggregateRootId();

        $this->when(
            new CreateNewContact(
                $id,
                self::OWNER_ID,
                new CarbonImmutable(self::CREATED_WHEN)
            )
        )->then(
            new ContactCreated(
                $id,
                self::OWNER_ID,
                new CarbonImmutable(self::CREATED_WHEN)
            )
        );
    }

    #[Test]
    public function make_throws_exception_when_contact_already_created(): void
    {
        $id = $this->aggregateRootId();

        $this->given(
            new ContactCreated($id, self::OWNER_ID, new CarbonImmutable(self::CREATED_WHEN)))
            ->when(
                new CreateNewContact($id, self::OWNER_ID, new CarbonImmutable(self::CREATED_WHEN))
            )->expectToFail(
                new \Exception('Contact already created')
            );
    }
}

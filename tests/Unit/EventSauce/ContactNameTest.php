<?php
declare(strict_types=1);

namespace Tests\Unit\EventSauce;

use App\EventSauce\Command\ChangeFolder;
use App\EventSauce\Command\SetFirstName;
use App\EventSauce\Command\SetLastName;
use App\EventSauce\Events\ContactCreated;
use App\EventSauce\Events\FirstNameWasSet;
use App\EventSauce\Events\FolderWasChanged;
use App\EventSauce\Events\LastNameWasSet;
use Carbon\CarbonImmutable;
use PHPUnit\Framework\Attributes\IgnoreDeprecations;
use PHPUnit\Framework\Attributes\Test;


#[IgnoreDeprecations]
class ContactNameTest extends ContactAggregateTestCase
{
    private const FIRST_NAME = 'John';
    private const LAST_NAME = 'Congdon';
    private const FOLDER = 'Friends';

    #[Test]
    public function contact_name_can_be_set(): void
    {
        $id = $this->aggregateRootId();

        $this->given(
            new ContactCreated($id, self::OWNER_ID, new CarbonImmutable(self::CREATED_WHEN)))
            ->when(
                new SetFirstName(self::FIRST_NAME),
                new SetLastName(self::LAST_NAME),
                new ChangeFolder(self::FOLDER),
            )->then(
                new FirstNameWasSet(self::FIRST_NAME),
                new LastNameWasSet(self::LAST_NAME),
                new FolderWasChanged(self::FOLDER),
            );
    }

    #[Test]
    public function make_throws_exception_when_contact_not_created(): void
    {
        $this->when(
            new SetFirstName(self::FIRST_NAME)
        )->expectToFail(
            new \Exception('First command must be CreateNewContact')
        );
    }

    public function make_throws_exception_when_contact_not_owned_by_current_user(): void
    {
        dump(auth()->loginUsingId(self::ID));
        dump(auth()->user());
        $this->given(
            new ContactCreated($this->aggregateRootId(), self::OWNER_ID, new CarbonImmutable(self::CREATED_WHEN))
        )->when(
            new SetFirstName(self::FIRST_NAME)
        )->expectToFail(
            new \Exception('First command must be CreateNewContact')
        );
    }
}

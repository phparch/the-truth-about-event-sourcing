<?php

namespace Database\Seeders;

use App\Events\ContactCreated;
use App\Events\ContactFolderChanged;
use App\Events\ContactUpdatedFirstName;
use App\Events\ContactUpdatedName;
use App\EventSauce\Command\SetFirstName;
use App\EventSauce\Command\SetLastName;
use App\EventSauce\ContactId;
use App\EventSauce\ContactRepository;
use App\Models\Contact;
use App\Models\User;
use App\States\ContactState;
use Carbon\CarbonImmutable;
use Illuminate\Database\Seeder;
use Thunk\Verbs\Facades\Verbs;

class DatabaseSeeder extends Seeder
{
    public function __construct(
        private readonly ContactRepository $contactRepository,
    ) { }

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::factory()->create([
            'name' => 'John Congdon',
            'email' => 'john@phparch.com',
        ]);

        auth()->loginUsingId($user->id);

        $start = microtime(true);
        $this->createVerbsContacts($user);
        $verbs = microtime(true) - $start;
        $start = microtime(true);
        $this->createEventSauceContacts($user);
        $eventsauce = microtime(true) - $start;

        print "Verbs: $verbs\n";
        print "EventSauce: $eventsauce\n";
    }

    private function createVerbsContacts(User $user): void
    {
        $faker = \Faker\Factory::create();

        Verbs::createMetadataUsing(fn() => [
            'user'=> 'Bob',
            'request' => [
                "folder" => "Needs Review",
            ],
            "server" => [
                "IP" => "127.0.0.1",
                "PATH" => "CLI",
                "METHOD" => "artisan",
            ]
        ]);

        foreach (range(1,100) as $contact_id)
        {
            ContactState::factory()->create([ 'id' => $contact_id, ]);
            ContactCreated::fire(contact_id: $contact_id, owner_id: $user->id, created_at: CarbonImmutable::now());
            ContactUpdatedFirstName::fire(contact_id: $contact_id, first_name: $faker->firstName());
            ContactUpdatedName::fire(contact_id: $contact_id, first_name: $faker->firstName(), last_name: $faker->lastName());
            ContactFolderChanged::fire(contact_id: $contact_id, folder: $faker->city());
        }

        $contact_id = 1;
        for ($x = 0; $x <= 1000; $x++)
        {
            ContactUpdatedFirstName::fire(contact_id: $contact_id, first_name: $faker->firstName());
        }

        print "Done           \n";
    }

    private function createEventSauceContacts(\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection $user)
    {
        $faker = \Faker\Factory::create();

        foreach (range(1,100) as $contact_id)
        {
            $contact_id = ContactId::fromString((string)$contact_id);
            $contact = \App\EventSauce\Contact::make($contact_id, $user->id, CarbonImmutable::now());

            $contact->process(new SetFirstName($faker->firstName()));
            $contact->process(new SetLastName($faker->lastName()));

            $this->contactRepository->persist($contact);
        }

        $contact = $this->contactRepository->retrieve(ContactId::fromString('1'));
        for ($x = 0; $x <= 1000; $x++) {
            $contact->process(new SetFirstName($faker->firstName()));
            print "$x            \r";
        }
        $this->contactRepository->persist($contact);
        print "\nDone           \n";
    }
}

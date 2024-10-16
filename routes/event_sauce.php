<?php

use App\EventSauce\Command\SetFirstName;
use App\EventSauce\Command\SetLastName;
use App\EventSauce\ContactId;
use App\EventSauce\ContactRepository;
use EventSauce\EventSourcing\MessageRepository;
use EventSauce\EventSourcing\UnableToReconstituteAggregateRoot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::get('/eventsauce/contact/{contact_id}', function (string $contact_id, ContactRepository $contactRepository, MessageRepository $messageRepository) {

    try {
        $contact = $contactRepository->retrieve(ContactId::fromString($contact_id));
    } catch (UnableToReconstituteAggregateRoot $e) {
        return response('Contact not found', 404);
    }

    $events = $messageRepository->retrieveAll($contact->aggregateRootId());

    return view('eventsauce_contact', ['contact' => $contact, 'events' => $events]);
});






Route::post('/eventsauce/contact/{contact_id}', function (string $contact_id, Request $request, ContactRepository $contactRepository) {
    $contact = $contactRepository->retrieve(ContactId::fromString($contact_id));

    if ($request->input('first_name') && $contact->getFirstName() !== $request->input('first_name')) {
        $contact->process(new SetFirstName($request->input('first_name')));
        $contactRepository->persist($contact);
    }
    if ($request->input('last_name') && $contact->getLastName() !== $request->input('last_name')) {
        $contact->process(new SetLastName($request->input('last_name')));
        $contactRepository->persist($contact);
    }
    if ($request->input('owner_id') && $contact->getOwnerId() !== (int)$request->input('owner_id')) {
        //not implemented
    }
    if ($request->input('folder') && $contact->getFolder() !== $request->input('folder')) {
        //not implemented
    }
    if ($request->input('email')) {
        //not implemented
    }

    return redirect()->back();
})->name('contact.eventsauce.store');





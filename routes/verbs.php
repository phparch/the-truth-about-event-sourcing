<?php

use App\Events\ContactEmailAdded;
use App\Events\ContactEmailRemoved;
use App\Events\ContactFolderChanged;
use App\Events\ContactTransferred;
use App\Events\ContactUpdatedFirstName;
use App\Events\ContactUpdatedLastName;
use App\States\ContactState;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Thunk\Verbs\Models\VerbEvent;


Route::get('/verbs/contact/{contact_state}', function (ContactState $contact_state) {
    $stored_events = $contact_state->storedEvents();
    $events = [];
    foreach ($stored_events as $event) {
        $model = VerbEvent::where('id', $event->id)->first();
        $events[] = $model;
    }

    return view('verbs_contact', ['contact' => $contact_state, 'events' => $events]);
});











Route::post('/verbs/contact/{contact_state}', function (ContactState $contact_state, Request $request) {

    if ($request->input('first_name') && $contact_state->getFirstName() !== $request->input('first_name')) {
        ContactUpdatedFirstName::fire(contact_id: $contact_state->id, first_name: $request->input('first_name'));
    }
    if ($request->input('last_name') && $contact_state->getLastName() !== $request->input('last_name')) {
        ContactUpdatedLastName::fire(contact_id: $contact_state->id, last_name: $request->input('last_name'));
    }
    if ($request->input('owner_id') && $contact_state->getOwnerId() !== (int)$request->input('owner_id')) {
        ContactTransferred::fire(contact_id: $contact_state->id, transferred_to: (int)$request->input('owner_id'));
    }
    if ($request->input('folder') && $contact_state->getFolder() !== $request->input('folder')) {
        ContactFolderChanged::fire(contact_id: $contact_state->id, folder: $request->input('folder'));
    }

    if ($request->input('email')) {
        ContactEmailAdded::fire(contact_id: $contact_state->id, email: $request->input('email'));
    }

    return redirect()->back();
})->name('contact.verb.store');










Route::post('/verbs.contact/{contact_state}/remove_email', function (ContactState $contact_state, Request $request) {
    ContactEmailRemoved::fire(contact_id: $contact_state->id, email: $request->input('email'));
    return redirect()->back();
})->name('contact.remove_email');









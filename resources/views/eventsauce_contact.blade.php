<form action="{{ route('contact.eventsauce.store', $contact->aggregateRootId()->toString()) }}" method="post">
    @csrf
    First: <input type="text" name="first_name" value="{{ $contact->getFirstName() }}"><br/>
    Last: <input type="text" name="last_name" value="{{ $contact->getLastName() }}"><br/>
    Owner: <input type="text" name="owner_id" value="{{ $contact->hasOwnerId() ? $contact->getOwnerId() : '' }}"><br/>
    Folder: <input type="text" name="folder" value="{{ $contact->getFolder() }}"><br/>
    Add email address: <input type="text" name="email" value=""><br/>
    <button type="submit">Submit</button>
</form>
<br/>
Emails:<br/>
@foreach($contact->getEmails() as $email)
    {{ $email }}<form method="post" action="{{ route('contact.remove_email', $contact->id) }}"><input type="hidden" name="email" value="{{ $email }}">@csrf<input type="submit" value="Remove"></form>
    <br/>
@endforeach

<br/>
<br/>

<h2>Events</h2>
@foreach($events as $event)
        @php dump($event); @endphp<br/>
@endforeach

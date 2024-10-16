<form action="{{ route('contact.verb.store', $contact->id) }}" method="post">
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
@foreach($contact->emails as $email)
    {{ $email }}<form method="post" action="{{ route('contact.remove_email', $contact->id) }}"><input type="hidden" name="email" value="{{ $email }}">@csrf<input type="submit" value="Remove"></form>
    <br/>
@endforeach

<br/>
<br/>

<h2>Events</h2>
@foreach($events as $event)
    @php #dump($event); @endphp<br/>
    @php $class = preg_replace('#.*Events.#', "", get_class($event)); @endphp
    {{ $event->type }}
    <p style="padding-left:20px;">
        Who: {{ $event->metadata['user']['name'] }}<br/>
        When: {{ $event->metadata['when'] }}<br/>
        What: {{ $event->metadata['when'] }}<br/>
        Where: {{ $event->metadata['server']['IP'] ?? $event->metadata['server']['REMOTE_ADDR'] ?? '' }}<br/>
        Why: {{ $event->metadata['server']['METHOD'] ?? '' }} {{ $event->metadata['server']['PATH'] ?? $event->metadata['server']['PATH_INFO'] ?? '' }}<br/>
    </p>

@endforeach

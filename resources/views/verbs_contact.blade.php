<x-app-layout>
    <div>
        <x-slot name="header">
            {{ __('Verbs') }}
        </x-slot>


        <div class="border-2 border-amber-500 rounded-2xl p-4 m-4 bg-gray-50 shadow-2xl text-lg w-1/2 mx-auto">
            <div>
                <form action="{{ route('contact.verb.store', $contact->id) }}" method="post">
                    @csrf
                    <div class="m-2">

                        First: <input
                            type="text"
                            name="first_name"
                            value="{{ $contact->getFirstName() }}"
                            class="border-1 rounded m-2 bg-gray-200 py-1.5 pl-2 text-gray-900 focus:ring-1 sm:text-sm sm:leading-6"
                        >
                    </div>
                    <div class="m-2">

                        Last: <input
                            type="text"
                            name="last_name"
                            value="{{ $contact->getLastName() }}"
                            class="border-1 rounded m-2 bg-gray-200 py-1.5 pl-2 text-gray-900 focus:ring-1 sm:text-sm sm:leading-6"
                        >
                    </div>
                    <div class="m-2">

                        Owner: <input
                            type="text"
                            name="owner_id"
                            value="{{ $contact->hasOwnerId() ? $contact->getOwnerId() : '' }}"
                            class="border-1 rounded m-2 bg-gray-200 py-1.5 pl-4 text-gray-900 focus:ring-1 sm:text-sm sm:leading-6"
                        >
                    </div>
                    <div class="m-2">

                        Folder: <input
                            type="text"
                            name="folder"
                            value="{{ $contact->getFolder() }}"
                            class="border-1 rounded m-2 bg-gray-200 py-1.5 pl-2 text-gray-900 focus:ring-1 sm:text-sm sm:leading-6"
                        >
                    </div>
                    <div class="m-2">

                        Add Email: <input
                            type="text"
                            name="email"
                            value=""
                            placeholder="email@example.com"
                            class="border-1 rounded m-2 placeholder-gray-400 placeholder:italic bg-gray-200 py-1.5 pl-2 text-gray-900 focus:ring-1 sm:text-sm sm:leading-6"
                        >
                    </div>
                    <button
                        class="bg-teal-600 text-white p-4 rounded-2xl border-4 border-amber-500
                    hover:bg-teal-800 hover:border-1 hover:border-amber-900 hover:font-extrabold"
                        type="submit">Submit
                    </button>
                </form>
            </div>
            <div class="mt-4 bg-gray-100 p-4">
                <div>
                    Emails:
                </div>
                @foreach($contact->emails as $email)
                    <div>
                        {{ $email }}
                        <form method="post" action="{{ route('contact.remove_email', $contact->id) }}">
                            <input type="hidden" name="email" value="{{ $email }}">@csrf

                            <input type="submit" value="Remove"></form>
                    </div>
                @endforeach
            </div>

            <div
                class="mx-auto m-4 gap-x-1 gap-y-2 text-sm">
                <div class="text-xl font-semibold">Events</div>
                @foreach($events as $event)
                    @php #dump($event); @endphp<br/>
                    @php $class = preg_replace('#.*Events.#', "", get_class($event)); @endphp
                    <div
                        class="p-6 justify-between border border-purple-400 bg-purple-200 rounded-2xl">
                        {{ $event->type }}
                        <div>
                            Who: {{ $event->metadata['user'] }}
                        </div>
                        <div>
                            What: @php print_r($event->metadata['request']); @endphp <br/>
                        </div>
                        <div>
                            When: {{ $event->created_at }}<br/>
                        </div>
                        <div>
                            Where: {{ $event->metadata['server']['IP'] ?? $event->metadata['server']['REMOTE_ADDR'] ?? '' }}
                        </div>
                        <div>
                            Why: {{ $event->metadata['server']['METHOD'] ?? '' }} {{ $event->metadata['server']['PATH'] ?? $event->metadata['server']['PATH_INFO'] ?? '' }}
                        </div>
                    </div>

                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <div>
        <x-slot name="header">
            {{ __('Contact Details') }}
        </x-slot>


        <div class="border-2 border-amber-500 rounded-2xl p-4 m-4 bg-gray-50 shadow-2xl text-2xl w-1/2 mx-auto">
            <h2 class=" font-semibold leading-7 text-gray-900">ID</h2>
            <p class="mt-1  leading-6 text-gray-600 border-b-2 border-gray-100 mb-2 p-4">{{ $contact->id }}</p>
            <h2 class=" font-semibold leading-7 text-gray-900">Name</h2>
            <p class="mt-1  leading-6 text-gray-600 border-b-2 border-gray-100 mb-2 p-4">{{ $contact->first_name }} {{ $contact->last_name }}</p>
            <h2 class=" font-semibold leading-7 text-gray-900">Owner ID</h2>
            <p class="mt-1  leading-6 text-gray-600 border-b-2 border-gray-100 mb-2 p-4">{{ $contact->owner_id }}</p>
            <h2 class=" font-semibold leading-7 text-gray-900">Folder</h2>
            <p class="mt-1  leading-6 text-gray-600 p-4">{{ $contact->folder }}</p>
        </div>
    </div>
</x-app-layout>

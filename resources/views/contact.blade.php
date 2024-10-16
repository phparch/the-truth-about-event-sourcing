<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reports') }}
        </h2>
    </x-slot>


<div>
    <table class="border-collapse border border-slate-500">
    <tr>
        <td>ID</td>
        <td>{{ $contact->id }}</td>
    </tr>
    <tr>
        <td>Name</td>
        <td>{{ $contact->first_name }} {{ $contact->last_name }}</td>
    </tr>
    <tr>
        <td>Owner ID</td>
        <td>{{ $contact->owner_id }}</td>
    </tr>
    <tr>
        <td>Folder</td>
        <td>{{ $contact->folder }}</td>
    </tr>
    </table>
</div>
</x-app-layout>

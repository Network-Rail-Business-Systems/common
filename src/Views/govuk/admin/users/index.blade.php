@extends('govuk::templates.custom')

@section('main')
    <x-govuk::p>This page allows you to manage Users.</x-govuk::p>

    <x-govuk::h2>Actions</x-govuk::h2>

    <x-govuk::ul spaced>
        <li>
            <x-govuk::a href="{{ route('admin.users.create') }}">
                Import a User
            </x-govuk::a>
        </li>

        <li>
            <x-govuk::a href="{{ route('admin.users.export') }}">
                Export shown Users as a CSV
            </x-govuk::a>
        </li>
    </x-govuk::ul>

    <x-govuk::section-break size="m" />

    <x-govuk::table
        :caption="$finder->caption"
        :data="$finder->results"
        empty-message="No Users found"
    >
        <x-govuk::table-column label="Name">
            ~name
        </x-govuk::table-column>

        <x-govuk::table-column label="E-mail">
            ~email
        </x-govuk::table-column>

        <x-govuk::table-column label="Roles">
            ~roles
        </x-govuk::table-column>

        <x-govuk::table-column label="" numeric>
            <x-govuk::a href="~link">Manage<x-govuk::hidden> ~name</x-govuk::hidden></x-govuk::a>
        </x-govuk::table-column>
    </x-govuk::table>

    <x-laravel-find::search-bar :finder="$finder" />
@endsection

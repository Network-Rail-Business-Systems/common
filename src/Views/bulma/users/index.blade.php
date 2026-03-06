@section('main')
    <x-govuk::p>This page allows you to manage Users.</x-govuk::p>

    <x-govuk::p>You can:</x-govuk::p>

    <x-govuk::ul bulleted spaced>
        <li>Select a User from the list below to manage them</li>
        <li>Create a new User</li>
        <li>Export a list of all Users in the system</li>
    </x-govuk::ul>

    <x-govuk::section-break />

    <x-govuk::table
        caption="Users"
        :data="$users"
        empty-message="No Users found"
    >
        <x-govuk::table-column label="Name">
            ~name
        </x-govuk::table-column>

        <x-govuk::table-column label="Roles">
            ~roles
        </x-govuk::table-column>

        <x-govuk::table-column label="" numeric>
            <x-govuk::a href="~link">Manage<x-govuk::hidden> ~name</x-govuk::hidden></x-govuk::a>
        </x-govuk::table-column>
    </x-govuk::table>
@endsection

@section('aside')
    <x-govuk::h2>Actions</x-govuk::h2>

    <x-govuk::ul spaced>
        <li>
            <x-govuk::a href="{{ route('admin.users.create') }}">
                Import a User
            </x-govuk::a>
        </li>

        <li>
            <x-govuk::a href="{{ route('admin.users.export') }}">
                Download a list of all Users as a CSV
            </x-govuk::a>
        </li>
    </x-govuk::ul>
@endsection

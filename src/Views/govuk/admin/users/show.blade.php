@section('main')
    <x-govuk::p>This page allows you to manage this User.</x-govuk::p>

    <x-govuk::p>You can:</x-govuk::p>

    <x-govuk::ul bulleted spaced>
        <li>Manage this User's Roles</li>
        @can('impersonate_users')
            <li>Impersonate this User</li>
        @endcan
        <li>View this User's activities</li>
    </x-govuk::ul>

    <x-govuk::section-break />

    <x-govuk::table
        caption="Roles"
        :data="$roles"
    >
        <x-govuk::table-column label="Name">
            ~name
        </x-govuk::table-column>

        <x-govuk::table-column label="Status">
            <x-govuk::tag label="~status" colour="~colour" />
        </x-govuk::table-column>

        <x-govuk::table-column label="" numeric hide="~hide">
            <x-govuk::form
                action="~link"
                method="POST"
            >
                <x-govuk::button as-link>~action<x-govuk::hidden> Role</x-govuk::hidden></x-govuk::button>
            </x-govuk::form>
        </x-govuk::table-column>
    </x-govuk::table>
@endsection

@section('aside')
    <x-govuk::h2>Actions</x-govuk::h2>

    <x-govuk::ul spaced>
        @canImpersonate
            @canBeImpersonated($user)
                <li>
                    <x-govuk::a href="{{ route('impersonate', $user) }}">
                        Impersonate this User
                    </x-govuk::a>
                </li>
            @endCanBeImpersonated
        @endCanImpersonate

        <li>
            <x-govuk::a href="{{ route('admin.users.actions', $user) }}">
                View actions performed by this User
            </x-govuk::a>
        </li>

        <li>
            <x-govuk::a href="{{ route('admin.users.activity', $user) }}">
                View activity log for this User
            </x-govuk::a>
        </li>
    </x-govuk::ul>
@endsection

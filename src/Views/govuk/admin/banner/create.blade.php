@extends('govuk::templates.question')

@section('before-main')
    <x-govuk::p>This page allows you to set a system wide banner which will show for all users on every page.</x-govuk::p>
    <x-govuk::p>Banners should be used for important impending messages, such as outages.</x-govuk::p>
    <x-govuk::p>Do not use banners for one-off messages, or messages only specific people should see.</x-govuk::p>
    <x-govuk::p>Setting a banner will show it immediately.</x-govuk::p>

    <x-govuk::h2>Actions</x-govuk::h2>
    <x-govuk::ul>
        <li>
            <x-govuk::a href="{{ route('admin.banner.clear') }}">Clear the current banner</x-govuk::a>
        </li>
    </x-govuk::ul>
@endsection

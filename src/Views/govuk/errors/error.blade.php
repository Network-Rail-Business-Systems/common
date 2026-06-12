@extends("govuk::errors.$status")

@section('after-main')
    <x-govuk::p>
        <x-govuk::a href="{{ route('support-page.show') }}" target="_blank">
            Contact the support team <x-govuk::hidden>(opens in a new tab)</x-govuk::hidden>
        </x-govuk::a> if you require further assistance.
    </x-govuk::p>
@endsection

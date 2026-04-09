@extends('govuk::templates.custom')

@section('main')
    <x-govuk::h2>How information about you will be used</x-govuk::h2>
    <x-govuk::p>This privacy policy relates to personal data processed by Network Rail Infrastructure Ltd, the data controller, via the following site:</x-govuk::p>
    <x-govuk::ul bulleted>
        <li>{{ config('app.url') }}</li>
    </x-govuk::ul>

    <x-govuk::h2>What information about you is held</x-govuk::h2>
    <x-govuk::p>The following personal data is stored within the system and within functional cookies:</x-govuk::p>
    <x-govuk::ul bulleted>
        @foreach($privacy as $entry)
            <li>{{ $entry }}</li>
        @endforeach
    </x-govuk::ul>

    <x-govuk::h2>How your information may be processed</x-govuk::h2>
    <x-govuk::p>Personal data will be processed for the purposes of contacting you and for the provision of services.</x-govuk::p>
    <x-govuk::p>Personal data will also be processed for usage analytics to help guide improvements to the system.</x-govuk::p>
    <x-govuk::p>Personal data will be disclosed to Network Rail employees who require access in order to organise provision of services.</x-govuk::p>
    <x-govuk::p>Personal data will also be disclosed to third parties which are contracted by Network Rail in order to provide services on Network Rail's behalf (for example, vehicle hire services and fuel cards).</x-govuk::p>
    <x-govuk::p>Individuals whose personal data is processed have the right to access their data and the right to ask for their data to be amended (for example, if it is inaccurate).</x-govuk::p>
    <x-govuk::p>Personal data will not be transferred outside the European Economic Area.</x-govuk::p>

    <x-govuk::h2>Who you can talk to about privacy</x-govuk::h2>
    <x-govuk::p>If you need any further information, please
        <x-govuk::a href="{{ route('enquiry') }}">contact the support team</x-govuk::a>.
    </x-govuk::p>
    <x-govuk::p>If you wish to raise a concern or speak with a Network Rail Data Protection Officer, you may e-mail them at:
        <x-govuk::a href="mailto:data.protection@networkrail.co.uk">data.protection@networkrail.co.uk</x-govuk::a>.
    </x-govuk::p>
    <x-govuk::p>Last reviewed on: 09/04/2026</x-govuk::p>
@endsection

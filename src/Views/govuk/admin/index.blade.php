@extends('govuk::templates.custom')

@section('main')
    <x-govuk::p>From this page you can manage various parts of the system.</x-govuk::p>
    <x-govuk::p>Select from one of the following options:</x-govuk::p>

    <x-govuk::ul spaced>
        @foreach($links as $label => $link)
            @if($link['permission'] !== null)
                @can($link['permission'])
            @endif

            <li>
                <x-govuk::a href="{{ $link['route'] }}">{{ $label }}</x-govuk::a>
            </li>

            @if($link['permission'] !== null)
                @endcan
            @endif
        @endforeach
    </x-govuk::ul>
@endsection

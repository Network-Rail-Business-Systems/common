@php
    $method = 'POST';
    $questions = $fields;
    $submitButtonMode = '';
    $submitButtonLabel = 'Import';
    $otherButtonHref = route('admin.users.index');
    $otherButtonMethod = 'GET';
    $otherButtonLabel = 'Cancel and back';
@endphp

@extends('govuk::templates.question')

@extends('common::errors.error', [
    'title' => 'Sorry, this page is restricted',
    'status_code' => '401',
    'status_message' => 'Authorisation restricted',
    'subtitle' => 'You do not have permission to access this resource',
    'message' => 'If you believe you should have access to this resource, get in touch.'
])

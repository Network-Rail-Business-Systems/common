@extends('common::errors.error', [
    'title' => 'Whew, give me a minute...',
    'status_code' => '429',
    'status_message' => 'Too Many Requests',
    'subtitle' => 'You have sent too many page requests to the server',
    'message' => 'Wait a few minutes before sending any more requests to the server.'
])

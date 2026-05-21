@extends('common::errors.error', [
    'title' => 'Sorry, that page was not found',
    'status_code' => '404',
    'status_message' => 'Not Found',
    'subtitle' => 'The page or resource does not exist',
    'message' => 'Try going back and refreshing the page. If you believe there should be something here, get in touch.'
])

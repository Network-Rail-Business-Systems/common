@extends('common::errors.error', [
    'title' => 'Sorry, this site is currently offline',
    'status_code' => '503',
    'status_message' => 'Service Unavailable',
    'subtitle' => 'The site is currently unavailable',
    'message' => $exception->getMessage()
])

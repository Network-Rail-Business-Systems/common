@extends('common::errors.error', [
    'title' => 'Whoops, something went wrong',
    'status_code' => '500',
    'status_message' => 'Internal Server Error',
    'subtitle' => 'Error Message',
    'message' => $exception->getMessage()
])

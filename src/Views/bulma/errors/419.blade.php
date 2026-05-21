@extends('common::errors.error', [
    'title' => 'Sorry, that page has expired',
    'status_code' => '419',
    'status_message' => 'Page Expired',
    'subtitle' => 'The resource you were attempting to access has expired',
    'message' => 'Try going back or logging in again, and accessing a fresh copy of the resource.'
])

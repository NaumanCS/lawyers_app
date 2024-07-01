@extends('front-layouts.master-layout')
@section('content')
<style>
    .chat-list {
    max-height: 400px; /* Adjust the max height as per your design */
    overflow-y: auto;
    padding-right: 15px; /* Add a bit of padding to prevent content from being obscured by scrollbar */
}

</style>
    <livewire:chat />
@endsection

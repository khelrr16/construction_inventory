@extends('layouts.others.layout')

@section('title', 'Title')

@section('content')

    <div class="max-w-7xl mx-auto py-4 px-4">
        <h3 class="text-xl font-semibold mb-3">Users</h3>
        <livewire:items-table />
    </div>
@endsection
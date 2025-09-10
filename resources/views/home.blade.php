@extends('layouts.layout')

@section('title', 'Home')

@section('content')
    @if(Auth::check() && Auth::user()->role === 'admin')
        <a href="{{ route('admin') }}">Go to Admin Dashboard</a>
    @endif

    <p><a href="{{route('new')}}">New Project</a></p>

    Project list... but it's empty
    
@endsection
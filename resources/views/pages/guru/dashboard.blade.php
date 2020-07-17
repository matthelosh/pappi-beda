@extends('index')

@section('content')
    @switch($page_title)
        @case('Dashboard')
            @include('pages.guru.home')
        @break
    @endswitch
@endsection
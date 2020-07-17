@extends('index')

@section('content')
    @switch($page_title)
        @case('Dashboard')
            @include('pages.admin.home')
        @break
        @case('User')
            @include('pages.admin.users')
        @break
        @case('Menu')
            @include('pages.admin.menus')
        @break
        @case('Data Sekolah')
            @include('pages.admin.sekolahs')
        @break

    @endswitch
@endsection
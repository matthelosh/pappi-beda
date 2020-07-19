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
        @case('Data Rombel')
            @include('pages.admin.rombels')
        @break
        @case('Data Siswa')
            @include('pages.admin.siswas')
        @break
        @case('Data Mapel')
            @include('pages.admin.mapels')
        @break
    @endswitch
@endsection
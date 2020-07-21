@extends('index')

@section('content')
    @switch($page_title)
        @case('Dashboard')
            @include('pages.guru.home')
        @break
        @case("Data Siswa")
            @include('pages.guru.siswaku')
        @break
        @case("Data Mapel")
            @include('pages.guru.mapelku')
        @break
        @case("Data Kompetensi")
            @include('pages.guru.kdku')
        @break
        @case('Data KKM')
            @include('pages.guru.kkm')
        @break
    @endswitch
@endsection
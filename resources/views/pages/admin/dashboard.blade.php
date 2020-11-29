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
        @case('Data Kompetensi')
            @include('pages.admin.kds')
        @break
        @case('Data Periode')
            @include('pages.admin.periode')
        @break
        @case('Tanggal Rapor')
            @include('pages.admin.tanggal-rapor')
        @break
        @case('Ekstrakurikuler')
            @include('pages.admin.ekskul')
        @break
    @endswitch
@endsection

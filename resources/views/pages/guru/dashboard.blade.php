{{-- 
Dashboard Guru

 --}}
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
        @case('Entri Nilai')
            @include('pages.guru.entri-nilai')
        @break
        @case('Rekap Nilai')
            @include('pages.guru.rekap-nilai')
        @break
        @case('Jurnal Sikap')
            @include('pages.guru.jurnal')
        @break
        @case('Cetak Rapor')
            @include('pages.guru.rapor')
        @break
        @case('Rapor Siswa')
            @include('pages.guru.cetak_rapor')
        @break
        @case('Tema')
            @include('pages.guru.tema')
        @break
        @case('Profil')
            @include('pages.guru.profil')
        @break
    @endswitch
@endsection
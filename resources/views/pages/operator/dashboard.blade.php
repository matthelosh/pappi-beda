 @extends('index')

 @section('content')
     @switch($page_title)
        @case('Dashboard')
            @include('pages.operator.home')
        @break
        @case('Pengguna')
            @include('pages.operator.user')
        @break
        @case('Siswa')
            @include('pages.operator.siswa')
        @break
        @case('Rombel')
            @include('pages.operator.rombel')
        @break
     @endswitch
 @endsection
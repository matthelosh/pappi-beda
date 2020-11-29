 @extends('index')

 @section('content')
     @switch($page_title)
         @case('Dashboard')
             @include('pages.operator.home')
         @break
         @case('Pengguna')
             @include('pages.operator.user')
         @break
     @endswitch
 @endsection
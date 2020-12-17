<!DOCTYPE html>
<!--
* CoreUI - Free Bootstrap Admin Template
* @version v3.2.0
* @link https://coreui.io
* Copyright (c) 2020 creativeLabs Łukasz Holeczek
* Licensed under MIT (https://coreui.io/license)
-->
<html lang="en">
  <head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> {{ Session::get('sekolah') ? Session::get('sekolah')->nama_sekolah : 'Administrator' }}  | {{ ($page_title) }}</title>
    {{-- <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('coreui/assets/favicon/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('coreui/assets/favicon/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('coreui/assets/favicon/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('coreui/assets/favicon/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('coreui/assets/favicon/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('coreui/assets/favicon/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('coreui/assets/favicon/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('coreui/assets/favicon/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('coreui/assets/favicon/apple-icon-180x180.png') }}"> --}}
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('img/favicon.png') }}">
    {{-- <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('coreui/assets/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('coreui/assets/favicon/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('coreui/assets/favicon/favicon-16x16.png') }}"> --}}
    <link rel="manifest" href="{{ asset('coreui/assets/favicon/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    {{-- <meta name="msapplication-TileImage" content="{{ asset('coreui/assets/favicon/ms-icon-144x144.png') }}"> --}}
    <meta name="theme-color" content="#ffffff">
    <!-- Main styles for this application-->
    <link href="{{ asset('datatables/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('coreui/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('jquery-ui/jquery-ui.css') }}" rel="stylesheet">
    <link href="{{ asset('jquery-ui/jquery-ui.structure.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/rapor.css') }}" rel="stylesheet">


    <!-- Global site tag (gtag.js) - Google Analytics-->
    <script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-118965717-3"></script>
    <script>
      window.dataLayer = window.dataLayer || [];

      function gtag() {
        dataLayer.push(arguments);
      }
      gtag('js', new Date());
      // Shared ID
      gtag('config', 'UA-118965717-3');
      // Bootstrap ID
      gtag('config', 'UA-118965717-5');
    </script>
    <link href="{{ asset('coreui/vendors/@coreui/chartjs/css/coreui-chartjs.css') }}" rel="stylesheet">
  </head>
  <body class="c-app">
    <div class="loading">
      <div class="text-center" style="padding-top: 20%;">
        <img src="{{ asset('img/pappi.png') }}" alt="Pappi Beda"  class="pulse"  />
        <br>
        {{-- <i class="mdi mdi-loading mdi-spin mdi-48px mx-auto;"></i> --}}
        <h4 id="text-loading"></h4>
      </div>
      
    </div>
    @include('layout.sidebar')
    <div class="c-wrapper c-fixed-components">
      @include('layout.header')
      <div class="c-body">
        @include('layout.content')
        @include('layout.footer')
      </div>
    </div>

    <div aria-live="polite" aria-atomic="true" style="position: relative; min-height: 200px;">
      <div class="toast" style="position: absolute; top: 0; right: 0;">
        <div class="toast-header">
          <svg class="bd-placeholder-img rounded mr-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" role="img"><rect width="100%" height="100%" fill="#007aff"/></svg>

          <strong class="mr-auto">Bootstrap</strong>
          <small>11 mins ago</small>
          <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="toast-body">
          Hello, world! This is a toast message.
        </div>
      </div>
    </div>

    {{-- @if(Auth::user()->level == 'admin') --}}
      @include('components.modaladmin')
    {{-- @endif --}}
    
    <script src="{{ asset('jquery/jquery.js') }}"></script>
    <script src="{{ asset('jquery-ui/jquery-ui.js') }}"></script>
    {{-- <script src="{{ asset('bootstrap/js/bootstrap.js') }}"></script> --}}
    <script src="{{ asset('datatables/datatables.js') }}"></script>
    <script>
      $(window).on('load', function(){
        // $('.loading').removeClass('d-flex').addClass('d-none')
        $('.loading').fadeOut()
      })
      // $(window).on('unload', function(){
      //   alert('hi')
      // })
    </script>
    <!-- CoreUI and necessary plugins-->
    <script src="{{ asset('coreui/vendors/@coreui/coreui/js/coreui.bundle.min.js') }}"></script>
    <!--[if IE]><!-->
    <script src="{{ asset('coreui/vendors/@coreui/icons/js/svgxuse.min.js') }}"></script>
    <!--<![endif]-->
    <!-- Plugins and scripts required by this view-->
    <script src="{{ asset('coreui/vendors/@coreui/chartjs/js/coreui-chartjs.bundle.js') }}"></script>
    <script src="{{ asset('coreui/vendors/@coreui/utils/js/coreui-utils.js') }}"></script>
    <script src="{{ asset('coreui/js/main.js') }}"></script>

    <script src="{{ asset('js/toastr.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('js/xlsx.full.min.js') }}"></script>
     <script>
      var headers =  {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
      $(document).on('click', '.c-sidebar-nav-dropdown-toggle', function(e) {
        e.preventDefault();
        $(this).parents('nav.c-sidebar').addClass('c-sidebar-show')
      })

        // Select Rombel
    $('.selRombel').select2({
        ajax: {
            headers: headers,
            url: '/rombels?req=select',
            type: 'post',
                dataType: 'json',
                delay: 250,
                processResults: function(response) {
                    return {
                        results: response.rombels
                    };
                },
                cache: true,

        },
    })
    // Select Mapel
    $('.selPeriode').select2({
        ajax: {
            headers: headers,
            url: '/periode?req=select',
            type: 'post',
                dataType: 'json',
                delay: 250,
                processResults: function(response) {
                    return {
                        results: response.periodes
                    };
                },
                cache: true,

        },
    })
    $('.selMapel').select2({

        ajax: {
            headers: headers,
            url: '/mapels?req=select',
            type: 'post',
                dataType: 'json',
                delay: 250,
                processResults: function(response) {
                    return {
                        results: response.mapels
                    };
                },
                cache: true,

        },
    })
     $('.selSekolah').select2({
        ajax: {
            headers: headers,
            url: '/sekolah?req=select',
            type: 'post',
                dataType: 'json',
                delay: 250,
                processResults: function(response) {
                    return {
                        results: response.sekolahs
                    };
                },
                cache: true,

        },
    })
    $('.selKds').select2({
      headers: headers,
            url: '/kds?req=select',
            type: 'post',
                dataType: 'json',
                delay: 250,
                processResults: function(response) {
                    return {
                        results: response.sekolahs
                    };
                },
                cache: true,
    })
    $('.select').select2()
    $('.selKd').select2()
    $(document).on('select2:select', '.selAspek', function(e){
            var mapel = $('.selMapel').val()
            var ki = e.params.data.id
            // alert(ki)  
            if(mapel == '0' || ki == '0') {
              swal('Error!','Harap Memilih Mapel dan Aspen Dulu','error')
            }
            if(sessionStorage.getItem('role') != 'wali' && $('select[name="rombel"]').val() == '0') {
              swal('Info', 'Pilih Rombel Dulu!', 'warning')
              return false
            }
            var data = {
              mapel:  $('.selMapel').val(),
              aspek:  ki,
              rombel: (sessionStorage.getItem('role') == 'wali') ? sessionStorage.getItem('rombel_id') : $('select[name="rombel"]').val()
            }

            $.ajax({
                headers: headers,
                type: 'post',
                dataType: 'json',
                url: '/kds?req=select',
                data: data,
                success: function(res){
                    var kdOpt = ''
                    res.forEach(item => {
                        kdOpt += `
                            <option value="${item.id}">${item.text}</option>
                        `
                        $('.selKd').html(kdOpt)
                    })
                }
            })
        })
    </script>

    @if(Session::get('status') == 'sukses')
      <script>
          $(document).ready(function(){
            toastr.options = {
            "closeButton": true,
            "debug": true,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": true,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "6000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
          }
            toastr.success("{{ Session::get('msg') }}", "{{ Session::get('status') }}")
          })
      </script>
    @endif
    @if(Session::get('status') == 'error')
      <script>
          $(document).ready(function(){
            toastr.options = {
            "closeButton": true,
            "debug": true,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": true,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "6000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
          }
            toastr.error("{{ Session::get('msg') }}", "{{ Session::get('status') }}")
          })
      </script>
    @endif
    <script>
      sessionStorage.setItem('role', "{{ Session::get('role') }}")
        sessionStorage.setItem('username', "{{ Session::get('username') }}")
        sessionStorage.setItem('periode', "{{ Session::get('periode_aktif') }}")
        sessionStorage.setItem('sekolah_id', "{{ Session::get('sekolah_id') }}")
    </script>
    @if(Auth::user()->level == 'admin' || Auth::user()->level == 'operator')
      <script src="{{ asset('js/main.js') }}"></script>
    @else
      <script>
        var rombel_id = "{{ Session::get('rombel_id') }}"
        var role = "{{ Session::get('role') }}"
        sessionStorage.setItem('rombel_id', rombel_id)
        
      </script>
      <script src="{{ asset('js/guru.js') }}"></script>

    @endif

    <script>
      
      $(document).on('click', '.foto-siswa', function(){
        $('#form-siswa input[name="foto_siswa"]').trigger('click')
      })

      var i = 0;
var txt = 'Sabar, Ya. Sebentar lagi selesai.'; /* The text */
var speed = 50; /* The speed/duration of the effect in milliseconds */

function typeWriter() {
  if (i < txt.length) {
    document.getElementById("text-loading").innerHTML += txt.charAt(i);
    i++;
    setTimeout(typeWriter, speed);
  }
}

typeWriter()

      function logout(e) {
        Swal.fire({
          title: 'Anda yakin keluar?',
          showCancelButton: true,
          confirmButtonText: 'Iya',
          cancelButtonText: 'Tidak Jadi',
          icon: 'warning'
        }).then((keluar) => {
          if(keluar.isConfirmed) {
            sessionStorage.clear()
            window.location.href = '/logout'
          }
        })
      }
    </script>
    

  </body>
</html>

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
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
    <title>ERAPOR GUGUS 1 SD NEGERI BEDALISODO | LOGIN</title>
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('coreui/assets/favicon/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('coreui/assets/favicon/apple-icon-60x60.pn ')}}g">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('coreui/assets/favicon/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('coreui/assets/favicon/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('coreui/assets/favicon/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('coreui/assets/favicon/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="assets/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('coreui/assets/favicon/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('coreui/assets/favicon/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('img/pappi.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/pappi.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('img/pappi.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/pappi.png') }}">
    <link rel="manifest" href="{{ asset('coreui/assets/favicon/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('coreui/assets/favicon/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">
    <!-- Main styles for this application-->
    <link href="{{ asset('coreui/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet">
    <!-- Global site tag (gtag.js) - Google Analytics-->
    {{-- <script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-118965717-3"></script>
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
    </script> --}}

  </head>
  <body class="c-app flex-row align-items-center">
    
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card-group">
            <div class="card p-4">
              <div class="card-body">
                <h1>Login</h1>
                <p class="text-muted">Monggo! Silahkan Masuk.</p>
                <form action="/login" method="post">
                  @csrf()
                  @error('username')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
                  <div class="input-group mb-3">
                    <div class="input-group-prepend"><span class="input-group-text">
                        <svg class="c-icon">
                          <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-user') }}"></use>
                        </svg></span>
                    </div>
                    <input class="form-control" type="text" name="username" placeholder="Username" value="{{ (Session::get('_old_input')) ? Session::get('_old_input')['username'] : '' }}">
                  </div>
                  @error('password')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
                  <div class="input-group mb-4">
                    <div class="input-group-prepend"><span class="input-group-text">
                        <svg class="c-icon">
                          <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-lock-locked') }}"></use>
                        </svg></span></div>
                    <input class="form-control" type="password" name="password" placeholder="Password">
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <button class="btn btn-square btn-primary px-4" type="submit">Login</button>
                    </div>
                    {{-- <div class="col-6 text-right">
                      <button class="btn btn-link px-0" type="button">Forgot password?</button>
                    </div> --}}
                  </div>
                  
                </form>
              </div>
            </div>
            <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
              <div class="card-body text-center">
                <div>
                  <img src="{{ asset('img/favicon.png') }}" alt="Logo Pappi" width="100px" style="position:relative;">
                  <h2>PAPPI BEDA</h2>
                  <p>Prgram Aplikasi Pengolahan dan Pelaporan Nilai Gugus 1  SD Negeri Bedalisodo</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> 
    
    {{-- {{ dd(Session::all()) }} --}}
    <!-- CoreUI and necessary plugins-->
    <script src="{{ asset('coreui/vendors/@coreui/coreui/js/coreui.bundle.min.js') }}"></script>
    <!--[if IE]><!-->
    <script src="{{ asset('coreui/vendors/@coreui/icons/js/svgxuse.min.js') }}"></script>
    <!--<![endif]-->
    <script src="{{ asset('jquery/jquery.js') }}"></script>
    <script src="{{ asset('js/toastr.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
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
  </body>
</html>
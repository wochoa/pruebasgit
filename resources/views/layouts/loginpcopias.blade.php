<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>

  <link rel="apple-touch-icon" sizes="180x180" href="{{asset('favicon/apple-touch-icon.png')}}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{asset('favicon/favicon-32x32.png')}}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{asset('favicon/favicon-16x16.png')}}">
  {{-- <link rel="manifest" href="{{asset('favicon/site.webmanifest')}}"> --}}
  <link rel="mask-icon" href="{{asset('favicon/safari-pinned-tab.svg')}}" color="#5bbad5">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="theme-color" content="#ffffff">
  
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body class="sidebar-mini layout-fixed control-sidebar-slide-open text-sm" style="padding: 0px !important; background-color: #b4c3c7;">
<div class="container" id="app">
  <div class="row justify-content-center mt-2" >
    <div class="col-md-8 col-sm-8 col-12">
      <div class="card">
        <div class="card-body rounded bg-gray p-2">
          <div class="row justify-content-center">
            <div class="col-sm-4 col-6 mb-2">
              {{-- muestra en escritorio --}}
              <div class="d-none d-sm-none d-md-block">
                <a href="/documentosdigitales" class="btn btn-sm btn-dark">
                  <i class="fa-regular fa-file-pdf"></i> VERIFICAR DOCUMENTO DIGITAL
                </a>
              </div>
              {{-- muestra en movil --}}
              <div class="d-block d-sm-block d-md-none">
                <a href="/documentosdigitales" class="btn btn-sm btn-dark">
                  <i class="fa-regular fa-file-pdf"></i> VER DOCUMENTO DIGITAL
                </a>
              </div>

            </div>
            <div class="col-sm-4 col-6 mb-2 text-center">
              <a href="/mesapartes" class="btn btn-sm  btn-danger">
                <i class="fa-solid fa-desktop"></i> MESA DE PARTES VIRTUAL
              </a>
            </div>
            <div class="col-sm-4 col-12 text-center">
              {{-- <div class="row">
                <div class="col-sm-9 col-9 pr-0">
                  <input type="number" class="form-control form-control-sm" placeholder="Nro expediente">
                </div>
                <div class="col-sm-3 col-3 pl-0">
                  <button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                </div>
              </div> --}}
              <buscar-expediente-gen
                {{-- route-expediente="{{route('tramite.expediente.index')}}"
                route-documento="{{route('tramite.buscar.buscarExpedienteModal','%s')}}" --}}
              >
              </buscar-expediente-gen>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<div class="row justify-content-center">
  <div class="login-box pt-5" >
  


  

    @yield('content')

  
</div>
</div>
</div>

<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
{{-- <script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script> --}}

<script src="{{ mix('js/app.js') }}" ></script>
</body>
</html>

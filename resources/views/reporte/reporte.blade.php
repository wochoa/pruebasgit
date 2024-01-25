<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Administrador</title>

  <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
  <link rel="manifest" href="/favicon/site.webmanifest">
  <link rel="mask-icon" href="/favicon/safari-pinned-tab.svg" color="#5bbad5">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="theme-color" content="#ffffff">
  
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body class="sidebar-mini layout-fixed control-sidebar-slide-open text-sm" style="padding: 0px !important;">
<div class="wrapper" id="app">
  <!-- Preloader -->
  {{-- <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{asset('dist/img/AdminLTELogo.png')}}" alt="AdminLTELogo" height="60" width="60">
  </div> --}}


  <div class="panel-group">
    <div class="panel panel-primary">
        <div class="panel-heading">REPORTES</div>
        <div class="panel-body">
        <Inicio
        route-user="{{route('obtenerUserDependenciaActivo')}}?tipo=4"
        route-archivador="{{route('archivador.obtenerArchivadores')}}?tipo=3"
        route-reporte="{{route('reporte.obtenerReporte')}}"
        titulo="{{env('TITULO_PAGINA')}}"
        :opciones='{!! json_encode($opciones) !!}'
        :tipo='{!! 1 !!}'
        ruta="{{route('home')}}"
        :usuario="{{Auth::user()?Auth::user():0}}"
        route-invoker-get="{{route('invoker.getArguments')}}"
        route-invoker-post="{{route('invoker.postArguments')}}" depenombre=""
        >
        </Inicio>
        </div>
    </div> 
</div>

   



  
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<script type="text/javascript">
  window.Laravel = {
      csrfToken: "{{ csrf_token() }}",
      jsPermissions: {!! auth()->check()?auth()->user()->jsPermissions():0 !!}
  }
</script>

<script type="module" src="{{ mix('js/app.js') }}" ></script>


</body>
</html>

<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MESA DE PARTES VIRTUAL</title>

  <link rel="apple-touch-icon" sizes="180x180" href="{{asset('favicon/apple-touch-icon.png')}}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{asset('favicon/favicon-32x32.png')}}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{asset('favicon/favicon-16x16.png')}}">
  {{-- <link rel="manifest" href="{{asset('favicon/site.webmanifest')}}"> --}}
  <link rel="mask-icon" href="{{asset('favicon/safari-pinned-tab.svg')}}" color="#5bbad5">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="theme-color" content="#ffffff">
  
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body class="hold-transition layout-top-nav" style="background: rgb(163,170,171);
background: linear-gradient(29deg, rgba(163,170,171,1) 27%, rgba(254,241,255,1) 100%);">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white pt-0 pb-0">
    <div class="container">
      <a href="/" class="navbar-brand">

        <img src="/img/grc.png" alt="" height="45px">
      </a>

      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">

      </div>

      
    </div>
  </nav>
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div  id="app">
      <Mesapartes />
  </div>
  <!-- /.content-wrapper -->



  {{-- <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper --> --}}

<!-- REQUIRED SCRIPTS -->

<script type="module" src="{{ mix('js/app.js') }}" ></script>
</body>
</html>

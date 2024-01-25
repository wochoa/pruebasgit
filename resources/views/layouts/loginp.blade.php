<!DOCTYPE html>
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
	<link rel="stylesheet" href="{{asset('td/estilos.css')}}">
</head>
<body>

	<div id="particles-js"></div>


  <div class="container" id="app">
    <div class="row justify-content-center" >
      <div class="col-md-8 col-sm-8 col-12">
        <div class="card" style="background: #ffffff59 !important">
          <div class="card-body rounded p-2">
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
                <a href="/mesapartes" class="btn btn-sm  btn-warning">
                  <i class="fa-solid fa-desktop"></i> MESA DE PARTES VIRTUAL
                </a>
              </div>
              <div class="col-sm-4 col-12 text-center">

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


	<script src="https://code.jquery.com/jquery-latest.js"></script>
	<script src="{{asset('td/particles.js')}}"></script>
	<script src="{{asset('td/particulas.js')}}"></script>
  <script src="{{ mix('js/app.js') }}" ></script>
</body>
</html>
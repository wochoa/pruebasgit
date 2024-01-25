<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>
	@section('titulo')
	{{env("TITULO_PAGINA")}}
	@show
	</title>

	<link href="{{ mix('css/app.css') }}" rel="stylesheet">
	{{-- <link rel="stylesheet" href="{{asset('css/estilos.css')}}">
	<base href="{{route('principal')}}"> --}}
</head>
<body>
    <div id="app">
        <Buscadocumentos
        {{-- route-documento="{{route('tramite.documento.buscarDocumento')}}"
        route-expediente="{{route('tramite.buscar.buscarExpedienteModal','%s')}}"
        :auth='{!! json_encode($auth)!!}' --}}
        :form-data='{!!json_encode((Object)['iddocumento'=>$iddocumento])!!}'
        >

        </Buscadocumentos>
    </div>


	<script type="module" src="{{ mix('js/app.js') }}" ></script>
</body>
</html>

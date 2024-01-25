<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>Solicitud de tramite</title>
</head>
<body>
    <h1 style="text-align: center; background-color: #9E0B26; color:#ffffff;">Notificación de Trámite Documentario</h1>
    <p>Estimado(a) Sr(a): <strong>{{$doc->docu_firma}}</strong>
        , Se le comunica a usted que ha registrado su trámite,queda a la espera del responsable de Mesa de Partes Virtual para su atención.</p>
    <ul>
        <li><strong>Dependencia Remitida: </strong> {{$doc->dependencia->depe_nombre}}</li>
        <li><strong>Asunto: </strong>{{$doc->docu_asunto}}</li>
        <li><strong>Entidad: </strong>{{$doc->docu_detalle}}</li>
        <li><strong>Firmante: </strong>{{$doc->docu_firma}}</li>
        @if($doc->docu_dni!=null)
            <li><strong>DNI: </strong>{{$doc->docu_dni}}</li>
        @elseif($doc->docu_ruc!=null)
            <li><strong>RUC: </strong>{{$doc->docu_ruc}}</li>
        @endif
        <li><strong>Teléfono: </strong>{{$doc->docu_telef}}</li>
        <li><strong>eMail: </strong>{{$doc->docu_emailorigen}}</li>
        <li><strong>CODIGO: </strong><b>{{$doc->codigo}}</b></li>
    </ul>
    <img src="{{asset('/img/membrete_header20.jpg')}}" alt="Gobierno Regional Cusco" width="250" />
    <p>Por favor no responder a esta dirección de correo, ya que este buzón es de envío automático.</p>
</body>
</html>

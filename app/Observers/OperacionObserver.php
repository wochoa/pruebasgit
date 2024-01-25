<?php

namespace App\Observers;

use App\Models\OPeracion;

class OperacionObserver
{
    /**
     * Handle the OPeracion "created" event.
     *
     * @param  \App\Models\OPeracion  $oPeracion
     * @return void
     */
    public function created(OPeracion $operacion)
    {
        if ($operacion->oper_idtope == 1) {
            
            $operacion->load('documento');
            if ($operacion->documento->docu_telef != null && strlen($operacion->documento->docu_telef) == 9 && $operacion->documento->docu_origen == 2) 
            {
                        $operacion->documento->load('tipoDocumento');
                        $operacion->load('dependencia');
                        $rutaapi   = env('API_WATSAPP');
                        $tocken=env('TOCKEN_API');
                        
                        $numero=$operacion->documento->docu_telef;
                        // $sms=urlencode("El documento {$operacion->documento->numero_documento} fue registrado en la  {$operacion->dependencia->depe_nombre} \nReg: {$operacion->documento->getIdString()}\nExp: {$operacion->documento->getExpedienteString()}");
                        $enlace=env('APP_URL');
                        $enlace=$enlace.'/buscar/buscarExpedienteModal/'.$operacion->documento->docu_idexma;


                        $rutaapi   .= '?token='.$tocken;                        
                        $rutaapi   .= "&to=+51{$operacion->documento->docu_telef}";
                        $rutaapi   .= "&body=";
                        $rutaapi   .= urlencode("SISTEMA DE GESTION DOCUMENTAL-GORE CUSCO, le informa el documento {$operacion->documento->getNumeroDocumentoAttribute()} fue registrado en la  {$operacion->dependencia->depe_nombre} Reg.Doc: {$operacion->documento->getIdString()} y Reg.Exp: {$operacion->documento->getExpedienteString()} , puede hacer seguimiento en:{$enlace}");
                        $respuesta = @file_get_contents($rutaapi);

                        // $MSG="<b>SISTEMA DE GESTION DOCUMENTAL-GORE CUSCO</b>, \nle informa el documento {$operacion->documento->getNumeroDocumentoAttribute()} fue registrado en la  {$operacion->dependencia->depe_nombre} \n<b>Reg.Doc: {$operacion->documento->getIdString()}</b> y <b>Reg.Exp: {$operacion->documento->getExpedienteString()}</b>, puede hacer seguimiento en:{$enlace}";
                        // // Should use UTF8
                        // $MSG        =  utf8_encode($MSG);

                        // // Whatsapp patterns
                        // // $nl         = "%0D%0A"; // newline
                        // $nl         = "%0A"; // newline
                        // $nl         = " "; // newline
                        // // $space      = "%20";    // space
                        // $space      = " ";    // space

                        // // Replace some Whatstapp tags 
                        // $MSG        =  str_replace( array("<b>","<bold>","</b>","</bold>"), array("*","*","*","*"), $MSG);

                        // // Replace newline to Whatsapp format
                        // $MSG        =  str_replace( array(" ","<br>","\n", "\r\n"), array($space,$nl,$nl,$nl), $MSG);

                        

                        // $curl = curl_init();

                        // curl_setopt_array($curl, array(
                        // CURLOPT_URL => "https://api.ultramsg.com/instance68880/messages/chat",
                        // CURLOPT_RETURNTRANSFER => true,
                        // CURLOPT_ENCODING => "",
                        // CURLOPT_MAXREDIRS => 10,
                        // CURLOPT_TIMEOUT => 30,
                        // CURLOPT_SSL_VERIFYHOST => 0,
                        // CURLOPT_SSL_VERIFYPEER => 0,
                        // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        // CURLOPT_CUSTOMREQUEST => "POST",
                        // CURLOPT_POSTFIELDS => '{
                        //     "token": "dcsfm7yrnwqu3eya",
                        //     "to": "+51'.$numero.'",
                        //     "body": "'.$MSG.'",
                        //     "priority": 10,
                        //     "referenceId": "",
                        //     "msgId": "",
                        //     "mentions": ""
                        // }',
                        //     CURLOPT_HTTPHEADER => array(
                        //         "content-type: application/json"
                        //     ),
                        // ));

                        // $response = curl_exec($curl);
                        // $err = curl_error($curl);

                        // curl_close($curl);

                        // if ($err) {
                        // $respuesta= "cURL Error #:" . $err;
                        // } else {
                        //     $respuesta=  $response;
                        // }

            }
        }
    }

    /**
     * Handle the OPeracion "updated" event.
     *
     * @param  \App\Models\OPeracion  $oPeracion
     * @return void
     */
    public function updated(OPeracion $oPeracion)
    {
        //
    }

    /**
     * Handle the OPeracion "deleted" event.
     *
     * @param  \App\Models\OPeracion  $oPeracion
     * @return void
     */
    public function deleted(OPeracion $oPeracion)
    {
        //
    }

    /**
     * Handle the OPeracion "restored" event.
     *
     * @param  \App\Models\OPeracion  $oPeracion
     * @return void
     */
    public function restored(OPeracion $oPeracion)
    {
        //
    }

    /**
     * Handle the OPeracion "force deleted" event.
     *
     * @param  \App\Models\OPeracion  $oPeracion
     * @return void
     */
    public function forceDeleted(OPeracion $oPeracion)
    {
        //
    }
}

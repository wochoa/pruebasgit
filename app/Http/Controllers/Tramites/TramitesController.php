<?php

namespace App\Http\Controllers\Tramites;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Tram_documento;
use App\Models\Tram_documentomain;
use App\Models\Operacion;
use App\Models\Depedencia;
use App\Models\DocumentoExterno;
use App\Models\Archivos;
use setasign\Fpdi\Fpdi;// para agregar contenido al PDF
use Illuminate\Support\Str;// para generar clave de 6 digitos
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SolicitudTramite;

class TramitesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        //Aqui se verifica si esta logueado
        $this->middleware('auth', ['except' => ['buscarExpedienteModal','buscarModal','buscarDigital','buscarDocExterno','nuevoDocExterno']]);

    }

    public function exportaword(Request $request)
    {



        $nom_anio=env('ANIO_NAME'); 

        $fasunto=strtoupper($request->fasunto);
        $fcargo=$request->fcargo;
        $fcargodestino=$request->fcargodestino;
        $fcod_unidad=$request->fcod_unidad;
        $fcodigounidad=$request->fcodigounidad;
        $fcorrelativodoc=$request->fcorrelativodoc;
        $fdetalle=$request->fdetalle;
        $fexpediente=$request->fexpediente;
        $ffechatramite=$request->ffechatramite;
        $iduser=Auth::user()->id;//$request->fidusercreador;
        $ffirma=$request->ffirma;
        $ffirmadestino=$request->ffirmadestino;
        $ffolios=$request->ffolios;
        $fformaderivacion=$request->fformaderivacion;
        $fformarecepcion=$request->fformarecepcion;
        $ffrregistro=$request->ffrregistro;
        $fnombre_oficina=$request->fnombre_oficina;
        $fnombredoc_export=$request->fnombredoc_export;
        $fprioridad=$request->fprioridad;
        $fproveido=strtoupper($request->fproveido);
        $freferencias=$request->freferencias;
        $fsiglasdoucmento=$request->fsiglasdoucmento;
        $ftipodocumento=$request->ftipodocumento;
        $ftipotramite=$request->ftipotramite;
        $funidadorganica=$request->funidadorganica;
        $fusuario=$request->fusuario;

        $fciudad=$request->fciudad;
        $fdireccion=$request->fdireccion;
        

        $nomword=$request->fnombredoc_export;
        //$iduser=4295;
        $anio=date('Y',strtotime($ffechatramite));
        $nomword=$iduser.'-'.$nomword.'-'.$anio;

        // id de Tram_docmuento retrnado
        //$regdoc=312453;// id de retorno de haber creado
        // si expediente es vacio entonces se tiene crear el la tabla Tram_documentomain returnando el id
        //if($fexpediente==null or $fexpediente==''){$fexpediente=189563;}



        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $fecha = Carbon::parse($ffechatramite);
        $mes = $meses[($fecha->format('n'))- 1];
        $fecha_tram= $fciudad.', '.$fecha->format('d') . ' de ' . $mes . ' de ' . $fecha->format('Y');// LA CIUDAD se jala DE DEPENDENCIA DONDE SE ENCUENTRA(provincia,distrito,localidad)
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $nombre_arhivo=DB::table('tram_tipodocumento')->where('idtdoc',$ftipodocumento)->value('nombre_archivo');
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $phpWord = new \PhpOffice\PhpWord\TemplateProcessor(Storage::path($nombre_arhivo));

        

        $numeracionsigla=str_pad($fcorrelativodoc,4,"0",STR_PAD_LEFT).'-'.$fsiglasdoucmento;
        $dircabecera=DB::table('tram_dependencia')->where('iddependencia',$fcodigounidad)->value('depe_imagen_header');
        // $logoencabezado=Storage::path('encabezado/'.$fcodigounidad.'.png');
        $logoencabezado=Storage::path($dircabecera);

        $phpWord->setImageValue('logodoc',array('path' => $logoencabezado, 'width' => 600, 'height' => 80, 'ratio' => false));

        $phpWord->setvalue('nomanio',$nom_anio);
        // $phpWord->setvalue('regdoc',$regdoc);// documento
        // $phpWord->setvalue('regexp',$fexpediente);// expediente

        $phpWord->setvalue('numeracionsigla',$numeracionsigla);
        ///             A                           /////////
        $phpWord->setvalue('ffirmadestino',$ffirmadestino);
        $phpWord->setvalue('fcargodestino',$fcargodestino);
        ///            DE /////////////////////////////////
        $phpWord->setvalue('firma',$ffirma);
        $phpWord->setvalue('cargo',$fcargo);
        /////////// asunto ////////////////////
        $phpWord->setvalue('asunto',$fasunto);
        $phpWord->setvalue('fecha',$fecha_tram);

        ///////// REFERENCIAS ///////////////////  
        if(@count($freferencias)>0){
            $valref='';
            $phpWord->setvalue('textrefe','Ref.:');
            if(count($freferencias)>1){
                for($i=0;$i<count($freferencias);$i++)
                {
                    $array_ref='('.($i+1).')'.json_decode($freferencias[$i])->value;
                    //$valref=$valref.$array_ref.'                            ';
                    $valref=$valref.$array_ref.'               ';
                   
                }
            }
            else{
                $array_ref=json_decode($freferencias[0])->value;
                $valref=$valref.$array_ref;
            }
           $phpWord->setvalue('referencias',$valref);
        }
        else{
            $phpWord->setvalue('textrefe','');
            $phpWord->setvalue('referencias','');
        }
        
        ///////////////////// FINAL DE REFERENCIAS //////////////////////////

        $clavedoc=$request->fclavedoc;//Str::random(6);//clave
        $phpWord->setvalue('clave',$clavedoc);
        $direcciondepedencia=$fdireccion;
        //  'Calle Calicanto 145-Amarilis-Hco
        // Teléfono: (062)51 2124
        // www.regionhuanuco.gob.pe
        // ';
        $phpWord->setvalue('dirdependencia',$direcciondepedencia);

       // $phpWord->saveAs(Storage::path('documentos_word/hola.docx'));

        $tempfile=tempnam(sys_get_temp_dir(),'PHPword');

        try{
            
            $phpWord->saveAs($tempfile);
        }catch(Exception $e){

        }
        $header=['Content-Type:aplication/octet-stream'];

        return response()->download($tempfile,$nomword.'.docx',$header);
    }

    public function actualizaciontramite(Request $request)
    {
        $datos=$request->all();
        $expediente=$request->fexpediente;
        $iddocumento=$request->iddocumento;

        $iduser=Auth::user()->id;
        $iddepe=DB::table('userofi')->where('id',$iduser)->value('depe_id');
        $formregistro=$request->ffrregistro;// tramite interno 1  externo 2

        $fderivaciones=$request->derivaciones;
        $archivo_rincipal=$request->file('files');// se obtiene archivo principal cargado 
        $archivo_anexo=$request->file('anexosfiles');// se obtiene archivo anexos cargado 

        $doc=Tram_documento::find($request->iddocumento);
        //documento
        if($formregistro==2)//cuando es externo
        {
            $doc->docu_iddependencia=$request->fcodigounidad;
            $doc->docu_dni=$request->fdni;
            $doc->docu_ruc=$request->fruc;
            $doc->docu_firma=strtoupper($request->ffirma);
            $doc->docu_cargo=strtoupper($request->fcargo);
            $doc->docu_telef=$request->ftelefono;
            $doc->docu_emailorigen=$request->femail;
            $doc->docu_idprioridad=$request->fprioridad;
            $doc->docu_idrecepcion=$request->fformarecepcion;

            $doc->docu_fecha_doc=$request->ffechatramite;
            $doc->docu_idtipodocumento=$request->ftipodocumento;
            $doc->docu_siglas_doc=strtoupper($request->fsiglasdoucmento);
            $doc->docu_numero_doc=$request->fcorrelativodoc;
            $doc->docu_asunto=strtoupper($request->fasunto);
            $doc->docu_folios=$request->ffolios;
            $doc->save();
        }
        else{// cuando la modificacion para tramite interno
            $doc->docu_fecha_doc=$request->ffechatramite;
            $doc->docu_idprioridad=$request->fprioridad;
            $doc->docu_idrecepcion=$request->fformarecepcion;
            $doc->docu_folios=$request->ffolios;
            $doc->docu_asunto=strtoupper($request->fasunto);
            $doc->save();
        }
        // BUSCAMOS EL ULTIMO OPERACION
        
        if($fderivaciones){// si existe array para las derivaciones
            //capturamos el id de operaciones de anterior(osea recien creado)
            $op=Operacion::where('oper_iddocumento',$iddocumento)->whereNull('oper_depeid_d')->orderBy('idoperacion','DESC')->limit(1)->value('idoperacion');
            // actualizamos el procesado en 1
            $pro=Operacion::find($op);
            $pro->oper_procesado=1;
            $pro->save();

            for($i=0;$i<count($fderivaciones);$i++)
                    {
                        $objeto=json_decode($request->derivaciones[$i]);// ya lo tengo formato json
                        $data                      = new Operacion();
                        $data->oper_iddocumento    =$iddocumento;
                        $data->oper_iddependencia  = intval($iddepe);
                        $data->oper_idusuario      = intval($iduser);
                        $data->oper_procesado      = 0;//isset($derivacion->oper_manual)?$derivacion->oper_manual:false;//coincide con oper_manual, por que si es manual se toma como procesado
                        $data->oper_idarchivador   = null;
                        $data->oper_idtope         = 2;//default para derivacion, 4: archivo o adjuntado
                        $data->oper_idprocesado    = $op;
                        // if($objeto->forma==false){
                        //     $operforma=0;
                        // }
                        // else{
                        //     $operforma=1;
                        // }
                        $data->oper_forma=intval($objeto->forma);//$operforma;
                        $data->oper_depeid_d=intval($objeto->vcodigoofcina);
                        $data->oper_usuid_d=intval($objeto->vcoduser);
                        $data->oper_detalledestino = mb_strtoupper($objeto->vdetalle);
                        $data->oper_acciones       = mb_strtoupper($objeto->vproveido);
                        $data->save();
                    }
        }

        // seccion donde guarda los archivos en el STORAGE y la tabla tram_files
        if($archivo_rincipal)
        {
            foreach($archivo_rincipal as $qdoc => $eldocu)
            {
                //$nombre= time()."-".$eldocu->getClientOriginalName();
                // $nombre= $iddocumento.'-'.$expediente."-".$eldocu->getClientOriginalName();
                $nombre= 'tramiteinterno/docuprincipal/'.date('Y').'/'.date('m').'/'.date('d').'/'.$iddocumento.'-'.$expediente."-".time().'.pdf';
                Storage::disk()->putFileAs('firmados', $eldocu, $nombre);
                //Storage::disk('firmados')->put( $eldocu, $nombre);
                // una vez cargado el word y pdf

               
                


                        // set the source file
                    $ubiacionfile_p='firmados/'.$nombre;
                    $docprincipal=0;//anexos=1
                    $patch=Storage::path($ubiacionfile_p);
                    // guradamos los files en la tabla: tram_file

                    //$this->guardarFile($ubiacionfile_p,$docprincipal,$iddocumento,$eldocu,null);
                    $anex=new Archivos();
                    $anex->file_url=$ubiacionfile_p;
                    $anex->file_name=$eldocu->getClientOriginalName();
                    $anex->file_tipo=$eldocu->getMimeType();
                    $anex->file_size=$eldocu->getSize();
                    $anex->file_mostrar=1;
                    $anex->file_principal=$docprincipal;
                    $anex->file_generado=0;// cuando no generan con el sistemas, osea lo cargar el PDF
                    $anex->id_documento=$iddocumento;
                    $anex->id_documento_externo=null;// en caso presenten por MPV
                    $anex->save();

                     //************** aqui viene la modificacion del PDF cargado, porque la conversion tiene defectos ********************

                    // initiate FPDI
                    $pdf = new Fpdi();

                    $pageCount=$pdf->setSourceFile($patch);

                    for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) 
                    {
                        

                        if($pageNo==1)
                        {
                            // import a page
                            $templateId = $pdf->importPage($pageNo);
                        
                            $pdf->AddPage();
                            // use the imported page and adjust the page size
                            $pdf->useTemplate($templateId, ['adjustPageSize' => true]);
                            // aqui se agrega el texto
                            $pdf->SetFont("Arial", "", 9);
                            $x=165;//157
                            $y=40;//26.4
                            $pdf->Rect($x, $y, 32.8, 7.7, 'D');

                            $pdf->SetXY($x,$y+2);
                            $pdf->write(0.1,'Reg.Doc.: '.str_pad($iddocumento, 8, "0", STR_PAD_LEFT));

                            
                            $pdf->Line($x, $y+3.8, $x+32.8, $y+3.8);

                            $pdf->SetXY($x,$y+6);
                            $pdf->write(0.1,'Reg.Exp.: '.str_pad($expediente, 8, "0", STR_PAD_LEFT));// nro registro expediente
                            
                        }
                        else{
                            // import a page
                            $templateId = $pdf->importPage($pageNo);
                        
                            $pdf->AddPage();
                            // use the imported page and adjust the page size
                            $pdf->useTemplate($templateId, ['adjustPageSize' => true]);
                            $x=153;//110
                            $y=40;//26.4 $pdf->SetXY($x,$y-1.5);
                            $pdf->SetXY($x,$y-1.5);
                            $pdf->write(0.1,'');
                        }
                    
                        

                    }


                    // // add a page
                    // $pdf->AddPage();
                    // // import page 1
                    // $tplId = $pdf->importPage(1);
                    // // use the imported page and place it at point 10,10 with a width of 100 mm
                    // //$pdf->useTemplate($tplId, null, null,null, 210,true);
                    // $pdf->useTemplate($tplId);

                    
                    $pdf->Output($patch, 'F');
                            
                // ***************** FINALIZA LA CONVERSION Y LO GUARDA ***************************************************************

                $arch_principal = ['archivoFirma'=>$ubiacionfile_p,'existe'=>1,'idfile'=>$anex->id,'idtramitedoc'=>$iddocumento]; 

            }
        }
        // cual el tramite se genera de forma fisica
        else{
            $arch_principal = ['archivoFirma'=>null,'existe'=>0,'idfile'=>null,'idtramitedoc'=>null];
        }   


        if($archivo_anexo)
        {
            foreach($archivo_anexo as $qdoc => $eldocu)
            {
                // $nombre_a= time()."-".$eldocu->getClientOriginalName();
                $nombre_a= 'tramiteinterno/docuanexos/'.date('Y').'/'.date('m').'/'.date('d').'/'.$iddocumento.'-'.time().'-'.$eldocu->getClientOriginalName();
                Storage::disk()->putFileAs('firmados', $eldocu, $nombre_a);

                $ubiacionfile='firmados/'.$nombre_a;
                $docprincipal=1;//anexos=1
                

                //$this->guardarFile($ubiacionfile,$docprincipal,$iddocumento,$eldocu,null);
                $anex=new Archivos();
                $anex->file_url=$ubiacionfile;
                $anex->file_name=$eldocu->getClientOriginalName();
                $anex->file_tipo=$eldocu->getMimeType();
                $anex->file_size=$eldocu->getSize();
                $anex->file_mostrar=1;
                $anex->file_principal=$docprincipal;
                $anex->file_generado=0;// cuando no generan con el sistemas, osea lo cargar el PDF
                $anex->id_documento=$request->iddocumento;
                $anex->id_documento_externo=null;// en caso presenten por MPV
                $anex->save();

                //Storage::disk('firmados')->put( $eldocu, $nombre_a);
                // una vez cargado el word y pdf
                // ***************** FINALIZA LA CONVERSION Y LO GUARDA ***************************************************************

                $arch_anexos[] = $nombre_a; 

            }
        }
        

        return response()->json($arch_principal, 200);

    }
    public function generacionnuevotramite( Request $request)
    {

        $iduser=Auth::user()->id;//$request->fidusercreador;//4295;// este id debe jalar del loguin

        // esto siempre se va generar cuando se crea el documento nuevo(expediente nuevo), 
        // mas no debe utilizar cuando es en respuesta al documento(ya tiene su expediente creado)
        
        if($request->fexpediente==''){// cuando no existe el expediente
            $documain=Tram_documentomain::create(['dmai_idusu'=>$iduser]);
            $expediente=$documain->iddocumentomain;
        }
        else{
            $expediente=$request->fexpediente;
        }



        $archivo_rincipal=$request->file('files');// se obtiene archivo principal cargado 
        $archivo_anexo=$request->file('anexosfiles');// se obtiene archivo anexos cargado 
        $frregistro=$request->ffrregistro;////1: interno, 2 externo
        $ftipodocumento=$request->ftipodocumento;
        
         // para el tipo de documento que se selecciona
         $operaciones_adjuntar=(Object)$request->operaciones;
        
        $fprioridad=$request->fprioridad;
        $fcodigounidad=$request->fcodigounidad;
        $fdetalle=$request->fdetalle;
        $ffirma=$request->ffirma;
        $fcargo=$request->fcargo;
        
        $fechatramite=$request->ffechatramite;
        $fcorrelativodoc=intval($request->fcorrelativodoc);
        $fcorrelativodocnew=intval($request->fcorrelativodocnew);
        $fsiglasdoucmento=strtoupper($request->fsiglasdoucmento);
        $fformarecepcion=$request->fformarecepcion;
        $ffolios=$request->ffolios;
        $fasunto=strtoupper($request->fasunto);
        $fclavedoc=$request->fclavedoc;
        $freferencias=$request->referencias;
        $fderivaciones=$request->derivaciones;
        
        if($request->fformaderivacion==false){
            $fformaderivacion=0;
        }
        else{
            $fformaderivacion=2;
        }

        $anio=date('Y');

        //averifiguar correlativo con la BD
        /*
        SE NECESITA :
        tdco_idtipodocumento,
        tdco_iddependencia,
        tdco_idusuario,
        tdco_periodo,
        */
        // si es con usuario 
        $ofi_opersonal=intval($request->ftipotramite);

        if($fcorrelativodoc==$fcorrelativodocnew)
        {
            $datocorrelativo=$this->averiguacorrelativo($ftipodocumento,$fcodigounidad,$ofi_opersonal,$iduser,$anio); 
            
        }
        else{
            $datocorrelativo=$fcorrelativodocnew;
        }

        // $datocorrelativo=$this->averiguacorrelativo($ftipodocumento,$fcodigounidad,$ofi_opersonal,$iduser,$anio);
        // $correlativo_final=$datocorrelativo?$datocorrelativo:$fcorrelativodocnew;

        // estas consultas sirven para luego actualizar el correlativo


        $fecha=date('Y-m-d H:i:s');

             $tram_documento = Tram_documento::create(
            [
                'docu_origen' => $frregistro,////1: interno, 2 externo
                'docu_tipo'=> $request->ftipotramite,//0: representante oficina  1: personal
                'docu_idprioridad'=> $fprioridad,// 1:normal, 2:urgente, 3:documento MINEDU,4: DRE
                'docu_forma'=> $fformaderivacion,//0: ORIGINAL, 2:copia
                'docu_digital'=> 0,//0: si se genera con el sistema, 1: documento cargado por MPV
                'docu_iddependencia'=> $fcodigounidad,// 2: usuario que pertenece a una dependencia
                // 'docu_ruc'=> 'hello world',
                'docu_detalle'=> $fdetalle,
                'docu_firma'=> $ffirma,//// del quien crea el documento
                'docu_cargo'=> $fcargo,

                'docu_idtipodocumento'=> $ftipodocumento,
                'docu_fecha_doc'=> $fechatramite,
                'docu_numero_doc'=> $datocorrelativo,//$correlativo_final,//$fcorrelativodocnew,
                'docu_siglas_doc'=> $fsiglasdoucmento,
                // 'docu_proyectado'=> 'hello world',
                'docu_idrecepcion'=> $fformarecepcion, //1 directa
                'docu_folios'=> $ffolios,
                'docu_asunto'=> $fasunto,
                'docu_relacionado'=> 0,
                'docu_idusuario'=> $iduser,
                'docu_idusuariodependencia'=> $fcodigounidad,
                // 'docu_emailorigen'=> 'hello world',
                // 'docu_archivo'=> 'hello world',
                'docu_estado'=> 1,
                'docu_clastupa'=> 9,
                // 'docu_diasatencion'=> 'hello world',
                // 'docu_idtdoc'=> 'hello world',
                // 'docu_numtdoc'=> 'hello world',
                // 'docu_idtupa'=> 'hello world',
                'docu_idexma'=> $expediente,// expediente
                // 'docu_domic'=> 'hello world',
                // 'docu_dni'=> 'hello world',
                // 'docu_telef'=> 'hello world',
                // 'docu_doc_generado'=> 'hello world',
                'docu_firma_electronica'=> 1,
                'docu_contrasenia'=> $fclavedoc,
                // 'docu_token'=> 'hello world',
                //'docu_referencias'=> json_decode($freferencias),// FALTA AGREGAR
                'created_at'=> $fecha,
                'updated_at'=> $fecha,

            ]);
            $iddocumento=$tram_documento->iddocumento;

            // ACTUALIZAMOS EL CORRELATIVO en la tabla: tram_tipodocumento_correl

            if($ofi_opersonal==0)// cuando el usuario no selecciona personal(se tramite desde la oficina)
            {  
                
                if($datocorrelativo==1)// si el correlativo es uno, queiere decir que no hay para actualiza, en ese caso se tiene que insertar como el primero
                {
                    $datocorrelativo++;
                    DB::insert('insert into tram_tipodocumento_correl (tdco_idtipodocumento,tdco_iddependencia,tdco_periodo,tdco_numero,created_at,updated_at) values (?, ?,?, ?,?, ?)', 
                    [$ftipodocumento, $fcodigounidad,$anio,$datocorrelativo,$fecha,$fecha]);
                }
                else{
                    $datocorrelativo++;
                    //  hacemos la consulta si ya existe doc. creado por parte de la oficina
                        if($fcorrelativodoc==$fcorrelativodocnew)
                            {
                                $idcorrelativo=DB::table('tram_tipodocumento_correl')->where(['tdco_idtipodocumento'=>$ftipodocumento,'tdco_periodo'=>$anio,'tdco_iddependencia'=>$fcodigounidad])->whereNull('tdco_idusuario')->value('id');
                                DB::update('update tram_tipodocumento_correl set tdco_numero = '.$datocorrelativo.' where id = ?', [$idcorrelativo]);
                                
                            }
                        else{
                            DB::insert('insert into tram_tipodocumento_correl (tdco_idtipodocumento,tdco_iddependencia,tdco_periodo,tdco_numero,created_at,updated_at) values (?, ?,?, ?,?, ?)',[$ftipodocumento, $fcodigounidad,$anio,$datocorrelativo,$fecha,$fecha]);
                         }
                    
                }
            }
            else{   
                // cuando el usuario selecciona personal
                if($datocorrelativo==1)// si el correlativo es uno, queiere decir que no hay para actualiza, en ese caso se tiene que insertar como el primero
                {
                    $datocorrelativo++;
                    DB::insert('insert into tram_tipodocumento_correl (tdco_idtipodocumento,tdco_iddependencia,tdco_idusuario,tdco_periodo,tdco_numero,created_at,updated_at) values (?, ?,?, ?,?, ?,?)', 
                    [$ftipodocumento, $fcodigounidad,$iduser,$anio,$datocorrelativo,$fecha,$fecha]);
                }
                else{
                    $datocorrelativo++;
                    //  hacemos la consulta si ya existe doc. creado por parte del personal
                    if($fcorrelativodoc==$fcorrelativodocnew)
                    {
                        $idcorrelativo=DB::table('tram_tipodocumento_correl')->where(['tdco_idtipodocumento'=>$ftipodocumento,'tdco_idusuario'=>$iduser,'tdco_periodo'=>$anio])->value('id');
                         DB::update('update tram_tipodocumento_correl set tdco_numero = '.$datocorrelativo.' where id = ?', [$idcorrelativo]);
                    }
                    else{
                        DB::insert('insert into tram_tipodocumento_correl (tdco_idtipodocumento,tdco_iddependencia,tdco_idusuario,tdco_periodo,tdco_numero,created_at,updated_at) values (?, ?,?, ?,?, ?,?)', 
                        [$ftipodocumento, $fcodigounidad,$iduser,$anio,$datocorrelativo,$fecha,$fecha]);
                    }

                }
            }

            
            
            // ACTUALIZAMOS en la tabla tram_operacion(GENERACION Y DERIVACIONES A OTRAS DEPENDENCIAS)
            if($fderivaciones){
                $operprocesado=1;//cuando existe array de derivaciones
            }
            else{
                $operprocesado=0;//cuando solo ha creado sin derivacion
            }
            
            // generando primer registro de operaciones
            $op                 = new Operacion();
            $op->oper_iddocumento = $iddocumento;
                if ($frregistro== 2) {
                    $op->oper_iddependencia = $fcodigounidad;
                } else {
                    $op->oper_iddependencia = $fcodigounidad;
                }
                $op->oper_idusuario = $iduser;
                $op->oper_idtope    = 1;
                $op->oper_es_destino     = 1;
                $op->oper_forma     = 0;
                $op->oper_manual     = 0;
                //requeridos
                $op->oper_procesado = $operprocesado;
                //$op->enviarSMS(); falta implementar
                $op->save();// la variable top guarda informacion el registro realizado


            
            // // generando registro de derivaciones
            // // aqui verificamos si existe array de derivaciones, de no ser asi => no se realiza ninguna accion
            if($operprocesado==1)// cuando hay derviaciones
            {
                //  Operacion::derivar($op, $fderivaciones);
                for($i=0;$i<count($fderivaciones);$i++)
                    {
                        $objeto=json_decode($request->derivaciones[$i]);// ya lo tengo formato json
                        $data                      = new Operacion();
                        $data->oper_iddocumento=$op->oper_iddocumento;
                        $data->oper_iddependencia  = intval($fcodigounidad);
                        $data->oper_idusuario      = intval($iduser);
                        $data->oper_procesado      = 0;//isset($derivacion->oper_manual)?$derivacion->oper_manual:false;//coincide con oper_manual, por que si es manual se toma como procesado
                        $data->oper_idarchivador   = null;
                        $data->oper_idtope         = 2;//default para derivacion
                        $data->oper_idprocesado    = $op->idoperacion;
                        if($objeto->forma==false){
                            $operforma=0;
                        }
                        else{
                            $operforma=0;
                        }
                        $data->oper_forma=$operforma;
                        $data->oper_depeid_d=intval($objeto->vcodigoofcina);
                        $data->oper_usuid_d=intval($objeto->vcoduser);
                        $data->oper_detalledestino = mb_strtoupper($objeto->vdetalle);
                        $data->oper_acciones       = mb_strtoupper($objeto->vproveido);
                        $data->save();
                    }
                
            }
           

        // seccion de aguardar archiv principal y anexos
        // EN ESTE CASO SE REALIZA DESPUES DE GENERAR EL DOCUMENTO (TENIENDO EL ID DE DOCUMENTO GENERADO SE GUARDA EN LA TABLA tram_file)
        // cuando el tramite es con archivo cargado o generado
        if($archivo_rincipal)
        {
            foreach($archivo_rincipal as $qdoc => $eldocu)
            {
                //$nombre= time()."-".$eldocu->getClientOriginalName();
                $nombre= 'tramiteinterno/docuprincipal/'.date('Y').'/'.date('m').'/'.date('d').'/'.$iddocumento.'-'.$expediente."-".time().'.pdf';//$eldocu->getClientOriginalName();
                Storage::disk()->putFileAs('firmados', $eldocu, $nombre);
                //Storage::disk('firmados')->put( $eldocu, $nombre);
                // una vez cargado el word y pdf

               
                


                        // set the source file
                    $ubiacionfile_p='firmados/'.$nombre;
                    $docprincipal=0;//anexos=1
                    $patch=Storage::path($ubiacionfile_p);
                    // guradamos los files en la tabla: tram_file

                    //$this->guardarFile($ubiacionfile_p,$docprincipal,$iddocumento,$eldocu,null);
                    $anex=new Archivos();
                    $anex->file_url=$ubiacionfile_p;
                    $anex->file_name=$eldocu->getClientOriginalName();
                    $anex->file_tipo=$eldocu->getMimeType();
                    $anex->file_size=$eldocu->getSize();
                    $anex->file_mostrar=1;
                    $anex->file_principal=$docprincipal;
                    $anex->file_generado=0;// cuando no generan con el sistemas, osea lo cargar el PDF
                    $anex->id_documento=$iddocumento;
                    $anex->id_documento_externo=null;// en caso presenten por MPV
                    $anex->save();

                     //************** aqui viene la modificacion del PDF cargado, porque la conversion tiene defectos ********************

                    // initiate FPDI
                    $pdf = new Fpdi();

                    $pageCount=$pdf->setSourceFile($patch);

                    for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) 
                    {
                        

                        if($pageNo==1)
                        {
                            // import a page
                            $templateId = $pdf->importPage($pageNo);
                        
                            $pdf->AddPage();
                            // use the imported page and adjust the page size
                            $pdf->useTemplate($templateId, ['adjustPageSize' => true]);
                            // aqui se agrega el texto
                            $pdf->SetFont("Arial", "", 9);
                            $x=165;//157
                            $y=40;//26.4
                           
                            $pdf->Rect($x, $y, 32.8, 7.7, 'D');

                            $pdf->SetXY($x,$y+2);
                            $pdf->write(0.1,'Reg.Doc.: '.str_pad($iddocumento, 8, "0", STR_PAD_LEFT));

                            $pdf->Line($x, $y+3.8, $x+32.8, $y+3.8);

                            $pdf->SetXY($x,$y+6);
                            $pdf->write(0.1,'Reg.Exp.: '.str_pad($expediente, 8, "0", STR_PAD_LEFT));// nro registro expediente
                        }
                        else{
                            // import a page
                            $templateId = $pdf->importPage($pageNo);
                        
                            $pdf->AddPage();
                            // use the imported page and adjust the page size
                            $pdf->useTemplate($templateId, ['adjustPageSize' => true]);
                            $x=153;//110
                            $y=40;//26.4 $pdf->SetXY($x,$y-1.5);
                            $pdf->SetXY($x,$y-1.5);
                            $pdf->write(0.1,'');
                        }
                    
                        

                    }


                    // // add a page
                    // $pdf->AddPage();
                    // // import page 1
                    // $tplId = $pdf->importPage(1);
                    // // use the imported page and place it at point 10,10 with a width of 100 mm
                    // //$pdf->useTemplate($tplId, null, null,null, 210,true);
                    // $pdf->useTemplate($tplId);

                    
                    $pdf->Output($patch, 'F');
                            
                // ***************** FINALIZA LA CONVERSION Y LO GUARDA ***************************************************************

                $arch_principal = ['archivoFirma'=>$ubiacionfile_p,'existe'=>1,'idfile'=>$anex->id,'idtramitedoc'=>$iddocumento,'expediente'=>$expediente]; 

            }
        }
        // cual el tramite se genera de forma fisica
        else{
            $arch_principal = ['archivoFirma'=>null,'existe'=>0,'idfile'=>null,'idtramitedoc'=>$iddocumento,'expediente'=>$expediente];
        }   


        if($archivo_anexo)
        {
            foreach($archivo_anexo as $qdoc => $eldocu)
            {
                // $nombre_a= time()."-".$eldocu->getClientOriginalName();
                $nombre_a= 'tramiteinterno/docuanexos/'.date('Y').'/'.date('m').'/'.date('d').'/'.$iddocumento.'-'.time().'-'.$eldocu->getClientOriginalName();
               
                Storage::disk()->putFileAs('firmados', $eldocu, $nombre_a);

                $ubiacionfile='firmados/'.$nombre_a;
                $docprincipal=1;//anexos=1
                

                //$this->guardarFile($ubiacionfile,$docprincipal,$iddocumento,$eldocu,null);
                $anex=new Archivos();
                $anex->file_url=$ubiacionfile;
                $anex->file_name=$eldocu->getClientOriginalName();
                $anex->file_tipo=$eldocu->getMimeType();
                $anex->file_size=$eldocu->getSize();
                $anex->file_mostrar=1;
                $anex->file_principal=$docprincipal;
                $anex->file_generado=0;// cuando no generan con el sistemas, osea lo cargar el PDF
                $anex->id_documento=$iddocumento;
                $anex->id_documento_externo=null;// en caso presenten por MPV
                $anex->save();

                //Storage::disk('firmados')->put( $eldocu, $nombre_a);
                // una vez cargado el word y pdf
                // ***************** FINALIZA LA CONVERSION Y LO GUARDA ***************************************************************

                $arch_anexos[] = $nombre_a; 

            }
        }

             
        if ($operaciones_adjuntar != null) {
            Operacion::adjuntarRespuesta($tram_documento->getIdString(), $operaciones_adjuntar);
        }

        //return json_encode($idmaindocument);
        //return json_decode($request->derivaciones[0]);
        //return json_decode($request->derivaciones[0]);

        return response()->json($arch_principal, 200);
        // return $idcorrelativo;
    }
    public function averiguacorrelativo($tipodoc,$iddepe,$tipotramite,$user,$anio)
    {
        if($tipotramite==0)// averiguamos si el tramite fue solo oficina
        {
            $correlativo=DB::table('tram_tipodocumento_correl')->where(['tdco_idtipodocumento'=>$tipodoc,'tdco_iddependencia'=>$iddepe,'tdco_periodo'=>$anio])->whereNull('tdco_idusuario')->value('tdco_numero');
            $correlativofinal=$correlativo?$correlativo:1;
        }
        else{
            $correlativo=DB::table('tram_tipodocumento_correl')->where(['tdco_idtipodocumento'=>$tipodoc,'tdco_iddependencia'=>$iddepe,'tdco_periodo'=>$anio,'tdco_idusuario'=>$user])->value('tdco_numero');
            $correlativofinal=$correlativo?$correlativo:1;
        }
        return $correlativofinal;
    }
    public function nuevoDocExterno(Request $request)
    {

        $archivo_rincipal=$request->file('principal');// se obtiene archivo principal cargado 
        $archivo_anexo=$request->file('anexos');// se obtiene archivo anexos cargado 
            
                if (!$request->id) 
                {

                    // buscamos datos para conseguir el codigo de tramite sacado de tram_persona_correo
                    $dni=$request->docu_dni;
                    $ruc=$request->docu_ruc;
                    $correo=$request->docu_emailorigen;
                    $docu_iddependencia=Depedencia::where('depe_nombre','like',$request->tipoadministrado)->value('iddependencia');
                    
                   
                    
                    //--------------------------------------------------------------------------------------------
                    $documento = new DocumentoExterno();
                    $documento->docu_iddependencia=$docu_iddependencia;
                    $documento->id_dependencia=$request->id_dependencia;
                    $documento->docu_detalle=$request->docu_detalle;
                    $documento->docu_firma=$request->docu_firma;
                    $documento->docu_cargo=$request->docu_cargo;
                    $documento->docu_idtipodocumento=$request->docu_idtipodocumento;
                    $documento->docu_fecha_doc=$request->docu_fecha_doc;
                    $documento->docu_numero_doc=$request->docu_numero_doc;
                    $documento->docu_siglas_doc=strtoupper($request->docu_siglas_doc);
                    $documento->docu_folios=$request->docu_folios;
                    $documento->docu_asunto=strtoupper($request->docu_asunto);
                    $documento->docu_emailorigen=$correo;
                    $documento->docu_estado=0;
                    $documento->docu_domic=strtoupper($request->docu_domic);
                    $documento->docu_dni=$dni;
                    $documento->docu_ruc=$ruc;
                    $documento->docu_telef=$request->docu_telef;
                    $documento->codigo=Str::random(6);
                    $documento->docu_token=Str::random(50);

                    $documento->save();                  

                        if($archivo_rincipal)
                        {
                            foreach($archivo_rincipal as $qdoc => $eldocu)
                            {
                                //$nombre= time()."-".$eldocu->getClientOriginalName();
                                // $nombre= 'tramitempv/docuprincipal/'.$request->id_dependencia.'/'.date('Y').'/'.date('m').'/'.date('d').'/'.time()."-".$eldocu->getClientOriginalName();
                                $nombre= 'tramitempv/docuprincipal/'.$request->id_dependencia.'/'.date('Y').'/'.date('m').'/'.date('d').'/'.time().".pdf";
                                Storage::disk()->putFileAs('firmados', $eldocu, $nombre);
                                //Storage::disk('firmados')->put( $eldocu, $nombre);
                                // una vez cargado el word y pdf

                                    // set the source file
                                    $ubiacionfile_p='firmados/'.$nombre;
                                    $docprincipal=0;//anexos=1
                                    $patch=Storage::path($ubiacionfile_p);// conseguimos la ruta
                                    // guradamos los files en la tabla: tram_file

                                    //$this->guardarFile($ubiacionfile_p,$docprincipal,$iddocumento,$eldocu,null);
                                    $anex=new Archivos();
                                    $anex->file_url=$ubiacionfile_p;
                                    $anex->file_name=$eldocu->getClientOriginalName();
                                    $anex->file_tipo=$eldocu->getMimeType();
                                    $anex->file_size=$eldocu->getSize();
                                    $anex->file_mostrar=1;
                                    $anex->file_principal=$docprincipal;
                                    $anex->file_generado=0;// cuando no generan con el sistemas, osea lo cargar el PDF
                                    $anex->id_documento_externo=$documento->id;// en caso presenten por MPV
                                    $anex->save();

                            }
                        }
                        // anexos
                        if($archivo_anexo)
                        {
                            foreach($archivo_anexo as $qdoc => $eldocu)
                            {
                                // $nombre_a= time()."-".$eldocu->getClientOriginalName();
                                $nombre_a= 'tramitempv/docuanexos/'.date('Y').'/'.date('m').'/'.date('d').'/'.time()."-".$eldocu->getClientOriginalName();
                                // $nombre_a= 'tramitempv/docuanexos/'.date('Y').'/'.date('m').'/'.date('d').'/'.time().".pdf";
                            
                                Storage::disk()->putFileAs('firmados', $eldocu, $nombre_a);

                                $ubiacionfile='firmados/'.$nombre_a;
                                $docprincipal=1;//anexos=1
                                

                                //$this->guardarFile($ubiacionfile,$docprincipal,$iddocumento,$eldocu,null);
                                $anex=new Archivos();
                                $anex->file_url=$ubiacionfile;
                                $anex->file_name=$eldocu->getClientOriginalName();
                                $anex->file_tipo=$eldocu->getMimeType();
                                $anex->file_size=$eldocu->getSize();
                                $anex->file_mostrar=1;
                                $anex->file_principal=$docprincipal;
                                $anex->file_generado=0;// cuando no generan con el sistemas, osea lo cargar el PDF
                                $anex->id_documento_externo=$documento->id;// en caso presenten por MPV (id del tram_documento_externo)
                                $anex->save();

                            }
                        }

                    
                    // \Mail::to($documento->docu_emailorigen)->from(array_rand (config('multimail.emails')))->queue(new SolicitudTramite($documento));
                    \Mail::to($documento->docu_emailorigen)->send(new SolicitudTramite($documento));
                    return response()->json(['status' => true, 'documento'=> $documento], 200);
                } else {
                    $documento                       = DocumentoExterno::find($request->id);
                    $documento->docu_idtipodocumento = $request->docu_idtipodocumento;
                    $documento->docu_numero_doc      = $request->docu_numero_doc;
                    $documento->docu_siglas_doc      = $request->docu_siglas_doc;
                    $documento->docu_folios          = $request->docu_folios;
                    $documento->docu_asunto          = $request->docu_asunto;
                    $documento->docu_estado          = 3;
                    $documento->subs_at              = Carbon::now();
                    $documento->save();


                    if($archivo_rincipal)
                    {
                        foreach($archivo_rincipal as $qdoc => $eldocu)
                        {

                            $nombre= 'tramitempv/docuprincipal/'.$request->id_dependencia.'/'.date('Y').'/'.date('m').'/'.date('d').'/'.time().".pdf";
                            Storage::disk()->putFileAs('firmados', $eldocu, $nombre);

                                // set the source file
                                $ubiacionfile_p='firmados/'.$nombre;
                                $docprincipal=0;//anexos=1
                                $patch=Storage::path($ubiacionfile_p);// conseguimos la ruta
                                // guradamos los files en la tabla: tram_file

                                //$this->guardarFile($ubiacionfile_p,$docprincipal,$iddocumento,$eldocu,null);
                                $anex=new Archivos();
                                $anex->file_url=$ubiacionfile_p;
                                $anex->file_name=$eldocu->getClientOriginalName();
                                $anex->file_tipo=$eldocu->getMimeType();
                                $anex->file_size=$eldocu->getSize();
                                $anex->file_mostrar=1;
                                $anex->file_principal=$docprincipal;
                                $anex->file_generado=0;// cuando no generan con el sistemas, osea lo cargar el PDF
                                $anex->id_documento_externo=$documento->id;// en caso presenten por MPV
                                $anex->save();

                        }
                    }
                    // anexos
                    if($archivo_anexo)
                    {
                        foreach($archivo_anexo as $qdoc => $eldocu)
                        {
                            $nombre_a= 'tramitempv/docuanexos/'.date('Y').'/'.date('m').'/'.date('d').'/'.time()."-".$eldocu->getClientOriginalName();                        
                            Storage::disk()->putFileAs('firmados', $eldocu, $nombre_a);
                            $ubiacionfile='firmados/'.$nombre_a;
                            $docprincipal=1;//anexos=1                            

                            $anex=new Archivos();
                            $anex->file_url=$ubiacionfile;
                            $anex->file_name=$eldocu->getClientOriginalName();
                            $anex->file_tipo=$eldocu->getMimeType();
                            $anex->file_size=$eldocu->getSize();
                            $anex->file_mostrar=1;
                            $anex->file_principal=$docprincipal;
                            $anex->file_generado=0;// cuando no generan con el sistemas, osea lo cargar el PDF
                            $anex->id_documento_externo=$documento->id;// en caso presenten por MPV (id del tram_documento_externo)
                            $anex->save();

                        }
                    }

                    return response()->json(['status' => true, 'documento'=> $documento], 200);
                }
           
    }
    public function guardarFile($ubiacionfile,$docprincipal,$idocumento,$archivo,$RegMPV)
    {
        $file_url=$ubiacionfile;
        $file_name=$archivo->getClientOriginalName();
        $file_tipo=$archivo->getMimeType();
        $file_size=$archivo->getSize();
        $file_mostrar=1;
        $file_principal=$docprincipal;
        $file_generado=0;// cuando no generan con el sistemas, osea lo cargar el PDF
        $id_documento=$idocumento;
        $id_documento_externo=$RegMPV;// en caso presenten por MPV
        


        DB::insert('insert into tram_file (file_url,file_name,file_tipo,file_size,file_mostrar,file_principal,file_generado,id_documento,id_documento_externo) values (?, ?,?,?,?,?,?,?,?)', 
            [$file_url,$file_name,$file_tipo,$file_size,$file_mostrar,$file_principal,$file_generado,$id_documento,$id_documento_externo]);

    }
    public function consulta_user($iddepe,$tipotram,$seldoc,$id)
    {
        //id del user 4295:wilmer ochoa alvarado de la tabla: admin
        $id=$id;//Auth::id();//4295;
        
        
        $idoficina=DB::table('userofi')->where(['id'=>$id,'depe_id'=>$iddepe])->value('depe_id');//2;// sale del id usuario
        $nombre=DB::table('userofi')->where(['id'=>$id,'depe_id'=>$iddepe])->value('adm_name');
        $apellidos=DB::table('userofi')->where(['id'=>$id,'depe_id'=>$iddepe])->value('adm_lastname');
        $nombreuser=$nombre.' '.$apellidos;// adm_name+adm_lastname
        $incialesuser=DB::table('userofi')->where(['id'=>$id,'depe_id'=>$iddepe])->value('adm_inicial');//'WOA';
        $cargouser=DB::table('userofi')->where(['id'=>$id,'depe_id'=>$iddepe])->value('adm_cargo');//'JEFE DE LA UNIDAD DE TRANSFORMACIÓN DIGITAL';


        // //CONSULTA PARA LA OFICINA EN CUESTION
        $nombreoficina=DB::table('tram_dependencia')->where('iddependencia',$idoficina)->value('depe_nombre');
        $siglaoficina=DB::table('tram_dependencia')->where('iddependencia',$idoficina)->value('depe_sigla');
        $representanteoficina=DB::table('tram_dependencia')->where('iddependencia',$idoficina)->value('depe_representante');
        $cargorepresnetante=DB::table('tram_dependencia')->where('iddependencia',$idoficina)->value('depe_cargo');
        // $depesuperior=DB::table('tram_dependencia')->where('iddependencia',$idoficina)->value('depe_superior');
        $logocabecera=DB::table('tram_dependencia')->where('iddependencia',$idoficina)->value('depe_imagen_header');
        $logopie=DB::table('tram_dependencia')->where('iddependencia',$idoficina)->value('depe_imagen_footer');

        $iddepe=DB::table('tram_dependencia')->where('iddependencia',$idoficina)->value('depe_depende');// para saber en qiedependecia esta

        $ciudad=DB::table('tram_dependencia')->where('iddependencia',$iddepe)->value('depe_ciudad');
        $direcciondepe=DB::table('tram_dependencia')->where('iddependencia',$iddepe)->value('depe_direccion');
        // $dat=json_decode($depesuperior);
        $idofisuperior=$iddepe;
        $nombreoficina_superior=DB::table('tram_dependencia')->where('iddependencia',$idofisuperior)->value('depe_nombre');

         // para el tipo de documento que se selecciona
        $anio=date('Y');
        $nombre_doc=DB::table('tram_tipodocumento')->where('idtdoc',$seldoc)->value('tdoc_descripcion');
        

        if($tipotram=='false')// cuando el usuario no selecciona personal(se tramite desde la oficina)
        {
            $siglas_tramite=$anio.'-'.$siglaoficina;
            $firma_tramite=$representanteoficina;
            $cargo_tramite=$cargorepresnetante;
            $correlativo=DB::table('tram_tipodocumento_correl')->where(['tdco_idtipodocumento'=>$seldoc,'tdco_periodo'=>$anio,'tdco_iddependencia'=>$idoficina])->whereNull('tdco_idusuario')->orderBy('id','DESC')->limit(1)->value('tdco_numero');
        }
        else
        {   $siglas_tramite=$anio.'-'.$siglaoficina.'-'.$incialesuser;
            $firma_tramite=$nombreuser;
            $cargo_tramite=$cargouser;
            $correlativo=DB::table('tram_tipodocumento_correl')->where(['tdco_idtipodocumento'=>$seldoc,'tdco_idusuario'=>$id,'tdco_periodo'=>$anio,'tdco_iddependencia'=>$idoficina])->orderBy('id','DESC')->limit(1)->value('tdco_numero');
        }
        $user_representante=[
                'iduser'=>$id,
                'idoficina'=>$idoficina,
                'iddependencia'=>$iddepe,
                'nombreuser'=>$nombreuser,
                'incialesuser'=>$incialesuser,
                'cargouser'=>$cargouser,
                'nombreoficina'=>$nombreoficina,
                'siglaoficina'=>$siglaoficina,
                'siglas_tramite'=>$siglas_tramite,
                'firma_tramite'=>$firma_tramite,
                'cargo_tramite'=>$cargo_tramite,
                'representanteoficina'=>$representanteoficina,
                'cargorepresnetante'=>$cargorepresnetante,
                'nombreoficina_superior'=>$nombreoficina_superior,
                'logocabecera'=>$logocabecera,
                'logopie'=>$logopie,
                'ciudad'=>$ciudad,
                'direccion'=>$direcciondepe,
                'tram_anio'=>$anio
            ];

        // para el tipo de documento que se selecciona 
        // $numcorrelativo=$correlativo+1;
        $numcorrelativo=$correlativo;  

        $tipodoc=['nombre_doc'=>$nombre_doc,'correlativo'=>$numcorrelativo];
        $clavedoc=Str::random(6);//clave

        // la lista de las unidades
        $dependencias=DB::table('tram_dependencia')->whereNotNull('depe_sigla')->whereNotNull('depe_depende')->where('depe_estado',1)->orderBy('depe_nombre','asc')->get();
        $oficinadepe=DB::table('tram_dependencia')->whereNotNull('depe_sigla')->where(['depe_estado'=>1,'depe_depende'=>$iddepe])->orderBy('depe_nombre','asc')->get();
       
        
         return  array('user_representante'=>$user_representante,'tipodoc'=>$tipodoc,'clavedoc'=>$clavedoc,'dependencias'=>$dependencias,'oficinadepe'=>$oficinadepe);
        
       
    }
    public function buscaregdoc($id)
    {
        /// si el registro con join con tipo documento
        $resultado=DB::table('tram_documento')->join('tram_tipodocumento','tram_documento.docu_idtipodocumento','=','tram_tipodocumento.idtdoc')->where('iddocumento',$id)->get();
        if(count($resultado)>0){
            $documento=$resultado[0]->tdoc_descripcion.' N°'.$resultado[0]->docu_numero_doc.'-'.$resultado[0]->docu_siglas_doc;
            $resultado=$documento;
            $codigo=$id;
        }
        else{
            $resultado=null;
            $codigo=0;
        }
        //$resultado=null;
        return response()->json(['resultado'=>$resultado,'codigo'=>$codigo]);

    }
    public function documentoenproceso(Request $request)
    {
        $depeid = Auth::user();
        
        $where = [
            ['o.oper_procesado', '=', 0],
            ['o.oper_iddependencia', '=', $depeid->depe_id],
            // ['td.idtdoc', '<>', env("TIPO_DOC_PAPELETA")],
        ];
        if (is_numeric($request->iddocumento) || $request->iddocumento == null)
            $request->iddocumento = intval($request->iddocumento);
        else
            return json_encode((Object)['current_page' => 1, 'data' => [], 'total' => 0]);
            
        if ($request->idadmin != null)
            $where[] = ['o.oper_idusuario', $request->idadmin];
        if ($request->iddocumento != null)
            $where[] = ['iddocumento', $request->iddocumento];
        if ($request->oper_idtope != null)
            $where[] = ['o.oper_idtope', $request->oper_idtope];
        if ($request->docu_digital != null)
            $where[] = ['docu_digital', $request->docu_digital];

        if ($request->tipdoc != null)/// agregado wilmer
            $where[] = ['docu_idtipodocumento', $request->tipdoc];
        
        if ($request->numdoc != null)/// agregado wilmer
            $where[] = ['docu_numero_doc', $request->numdoc];
        
        if ($request->asuntodoc != null)/// agregado wilmer
            $where[] = ['docu_asunto', $request->asuntodoc];


        return Tram_documento::select([
            'o.idoperacion',
            'iddocumento',
            'docu_idexma',
            'docu_origen',
            'docu_fecha_doc',
            'o.oper_forma',
            'o.oper_acciones',
            'o.oper_detalledestino',
            'docu_folios',
            'td.tdoc_descripcion',
            'docu_numero_doc',
            'docu_siglas_doc',
            'docu_firma',
            'docu_cargo',
            'docu_asunto',
            'docu_iddependencia as depe_origen',// oficina emisor
            'ddest.depe_nombre as depe_nombre_origen',
            'o.oper_idtope',
            'o.oper_depeid_d as depe_destino',// oficina destino
            'ddoc.depe_nombre as depe_nombre_destino',
            'o.oper_usuid_d',// usuario destino a quien se deriva
            'docu_idtipodocumento',
            'u1.adm_name as nameuser_destino',
            'u1.adm_lastname as lastnameuser_destino',
            'docu_idusuario',
            //'u.depe_id',
            'o.oper_idusuario',
            'u1.adm_estado',
            'docu_doc_generado',
            'docu_firma_electronica',
            'docu_digital',
            'depe.depe_recibetramite',
            'o.created_at',
        ])
            ->with('docuArchivo')// con la funcion(docuArchivo) del mismo modelo(o sea de Tram_documento)
            ->join('tram_operacion as o', 'iddocumento', '=', 'o.oper_iddocumento')
            ->join('tram_tipodocumento as td', 'docu_idtipodocumento', '=', 'td.idtdoc')
            ->leftJoin('tram_dependencia AS depe', 'o.oper_iddependencia', '=', 'depe.iddependencia')
            ->leftJoin('tram_dependencia as ddoc', 'o.oper_depeid_d', '=', 'ddoc.iddependencia')
            ->leftJoin('tram_dependencia as ddest', 'docu_iddependencia', '=', 'ddest.iddependencia')
            //->leftJoin('admin as u', 'oper_usuid_d', '=', 'u.id')
            ->leftJoin('admin as u1', 'o.oper_usuid_d', '=', 'u1.id')
            ->where($where)
            ->where(function ($query) {
                $query->where('o.oper_idtope', '=', 1)
                    ->orWhere('o.oper_idtope', '=', 2);
            })
            ->orderBy('o.idoperacion', 'desc')
            ->paginate(10);
    //return $depeid
    }

    
    public function porRecibir(Request $request)
    {
        $where = [
            ['o.oper_procesado', '=', 0],
            ['o.oper_depeid_d', '=', Auth::user()->depe_id],
            ['o.oper_idtope', '=', 2],
            ['td.idtdoc', '<>', env("TIPO_DOC_PAPELETA")],
        ];

        if (is_numeric($request->iddocumento) || $request->iddocumento == null)
            $request->iddocumento = intval($request->iddocumento);
        else
            return json_encode((Object)['current_page' => 1, 'data' => [], 'total' => 0]);

        if ($request->iddocumento != null) {
            $where[] = ['iddocumento', '=', $request->iddocumento];
        }
        if ($request->idadmin != null) {
            $where[] = ['o.oper_usuid_d', '=', $request->idadmin];
        }

        return Tram_documento::select([
            'o.idoperacion',
            'iddocumento',
            'docu_idexma',
            'docu_origen',
            'docu_fecha_doc',
            'o.oper_forma',
            'docu_folios',
            'td.tdoc_descripcion',
            'docu_numero_doc',
            'docu_siglas_doc',
            'ddoc.depe_nombre as depe_nombre_destino',
            'docu_detalle',
            'ddest.depe_nombre as depe_nombre_origen',
            'docu_firma',
            'docu_cargo',
            'docu_asunto',
            'docu_digital',
            'u.adm_name as name_usuario',
            'u.adm_lastname as lastname_usuario',
            'o.created_at',
            'u1.adm_name as name_usuario_destino',
            'u1.adm_lastname as lastname_usuario_destino',
            'o.oper_usuid_d',
        ])
            ->with('docuArchivo')
            ->join('tram_operacion as o', 'iddocumento', '=', 'o.oper_iddocumento')
            ->join('tram_tipodocumento as td', 'docu_idtipodocumento', '=', 'td.idtdoc')
            ->leftJoin('tram_dependencia as ddoc', 'o.oper_depeid_d', '=', 'ddoc.iddependencia')
            ->leftJoin('tram_dependencia as ddest', 'docu_iddependencia', '=', 'ddest.iddependencia')
            ->leftJoin('admin AS u1', 'o.oper_usuid_d', '=', 'u1.id')
            ->join('admin AS u', 'o.oper_idusuario', '=', 'u.id')
            ->where($where)
            ->orderBy('o.idoperacion', 'asc')
            ->paginate(10);

    }

    public function archivados(Request $request)
    {
        $where = [

            ['o.oper_iddependencia', '=', Auth::user()->depe_id],
            ['o.oper_procesado', '=', 0],
        ];

        if (is_numeric($request->iddocumento) || $request->iddocumento == null)
            $request->iddocumento = intval($request->iddocumento);
        else
            return json_encode((Object)['current_page' => 1, 'data' => [], 'total' => 0]);

        if ($request->oper_idusuario != null) {
            $where[] = ['o.oper_idusuario', '=', $request->oper_idusuario];
        }
        if ($request->idarch != null) {
            $where[] = ['o.oper_idarchivador', '=', $request->idarch];
        }
        if ($request->oper_tarchi_id != null) {
            $where[] = ['o.oper_tarchi_id', '=', $request->oper_tarchi_id];
        }
        if ($request->iddocumento != null) {
            $where[] = ['o.oper_iddocumento', '=', $request->iddocumento];
        }

        return Tram_documento::select([
            'o.idoperacion',
            'iddocumento',
            'o.oper_iddocumento',
            'o.oper_iddocumento_adj',
            'ta.arch_periodo',
            'ta.arch_nombre',
            'tdo.tdoc_descripcion',
            'docu_origen',
            'docu_fecha_doc',
            'docu_numero_doc',
            'docu_siglas_doc',
            'docu_firma',
            'docu_cargo',
            'o.oper_acciones',
            'docu_asunto',
            'docu_digital',
            'td.depe_nombre',
            'o.created_at as fecha_archivado',
            'a.adm_name',
            'a.adm_lastname',
            'o.oper_idprocesado',
        ])
            ->with('docuArchivo')
            ->join('tram_operacion as o', 'iddocumento', '=', 'o.oper_iddocumento')
            ->join('tram_tipodocumento as tdo', 'docu_idtipodocumento', '=', 'tdo.idtdoc')
            ->join('tram_dependencia as td', 'o.oper_iddependencia', '=', 'td.iddependencia')
            ->leftJoin('tram_archivador as ta', 'o.oper_idarchivador', '=', 'ta.idarch')
            ->join('admin as a', 'o.oper_idusuario', '=', 'a.id')
            ->where($where)
            //->whereIn('oper_idtope', [3, 4])
            ->where(function ($query) {
                $query->where('o.oper_idtope', '=', 3)
                    ->orWhere('o.oper_idtope', '=', 4);
            })
            ->orderBy('o.idoperacion', 'desc')
            ->paginate(10);

    }

    

    public function countDocumento($tipo)
    {
        switch ($tipo) {
            case '1' :
                {
                    $where = [
                        ['oper_procesado', '=', 0],
                        ['oper_iddependencia', '=', Auth::user()->depe_id],
                        ['td.idtdoc', '<>', env("TIPO_DOC_PAPELETA")],
                        ['oper_idtope', '<>', 3],
                        ['oper_idtope', '<>', 4],
                    ];
                }
                break;
            case '2' :
                {
                    $where = [
                        ['oper_procesado', '=', 0],
                        ['oper_iddependencia', '=', Auth::user()->depe_id],
                        ['td.idtdoc', '<>', env("TIPO_DOC_PAPELETA")],
                        ['oper_idtope', '=', 2],
                    ];
                }
                break;
            case '3' :
                {
                    $where = [
                        ['oper_procesado', '=', 0],
                        ['oper_iddependencia', '=', Auth::user()->depe_id],
                        ['td.idtdoc', '<>', env("TIPO_DOC_PAPELETA")],
                        ['oper_idtope', '<>', 3],
                        ['oper_idtope', '<>', 4],
                        ['oper_idusuario', '=', Auth::user()->id],
                    ];
                }
                break;
            case '4' :
                {
                    $where = [
                        ['oper_procesado', '=', 0],
                        ['oper_depeid_d', '=', Auth::user()->depe_id],
                        //['oper_idusuario', '<>', Auth::user()->id],
                        ['oper_idtope', '=', 2],
                        ['td.idtdoc', '<>', env("TIPO_DOC_PAPELETA")],
                    ];

                    return Operacion::where($where)
                        ->join('tram_documento as d', 'oper_iddocumento', '=', 'd.iddocumento')
                        ->join('tram_tipodocumento as td', 'd.docu_idtipodocumento', '=', 'td.idtdoc')
                        ->leftJoin('tram_dependencia as ddoc', 'oper_depeid_d', '=', 'ddoc.iddependencia')
                        ->leftJoin('tram_dependencia as ddest', 'd.docu_iddependencia', '=', 'ddest.iddependencia')
                        ->leftJoin('admin AS u1', 'oper_usuid_d', '=', 'u1.id')
                        ->join('admin AS u', 'oper_idusuario', '=', 'u.id')
                        ->count();
                }
                break;
            case '5' :
                {
                    $where = [
                        ['oper_procesado', '=', 0],
                        ['oper_depeid_d', '=', Auth::user()->depe_id],
                        ['oper_usuid_d', '=', Auth::user()->id],
                        ['oper_idtope', '=', 2],
                        ['td.idtdoc', '<>', env("TIPO_DOC_PAPELETA")],
                    ];

                    return Operacion::where($where)
                        ->join('tram_documento as d', 'oper_iddocumento', '=', 'd.iddocumento')
                        ->join('tram_tipodocumento as td', 'd.docu_idtipodocumento', '=', 'td.idtdoc')
                        ->leftJoin('tram_dependencia as ddoc', 'oper_depeid_d', '=', 'ddoc.iddependencia')
                        ->leftJoin('tram_dependencia as ddest', 'd.docu_iddependencia', '=', 'ddest.iddependencia')
                        ->leftJoin('admin AS u1', 'oper_usuid_d', '=', 'u1.id')
                        ->join('admin AS u', 'oper_idusuario', '=', 'u.id')
                        ->count();
                }
                break;
            case '6' :
                {
                    $where = [
                        ['oper_iddependencia', '=', Auth::user()->depe_id],
                        ['oper_procesado', '=', 0],
                        ['oper_idtope', '<>', 1],
                        ['oper_idtope', '<>', 2],
                    ];
                    return Operacion::where($where)
                        ->count();
                }
                break;
            case '7' :
                {
                    $where = [
                        ['oper_iddependencia', '=', Auth::user()->depe_id],
                        ['oper_procesado', '=', 0],
                        ['oper_idtope', '<>', 1],
                        ['oper_idtope', '<>', 2],
                        ['oper_idusuario', '=', Auth::user()->id],
                    ];
                    return Operacion::where($where)
                        ->count();
                }
                break;
            case '8' :
                {
                    $where = [
                        ['plt_iddependencia', '=', Auth::user()->depe_id],
                    ];
                    return Plantilla::where($where)
                        ->count();
                }
                break;
            case '9' :
                {
                    $where = [
                        ['plt_iddependencia', '=', Auth::user()->depe_id],
                        ['plt_idadmin', '=', Auth::user()->id],
                    ];
                    return Plantilla::where($where)
                        ->count();
                }
                break;
            case '10' :
                {
                    $where = [
                        ['dgen_iddependencia', '=', Auth::user()->depe_id],
                    ];
                    return DocGenerado::where($where)
                        ->count();
                }
                break;
            case '11' :
                {
                    $where = [
                        ['dgen_iddependencia', '=', Auth::user()->depe_id],
                        ['dgen_idadmin', '=', Auth::user()->id],
                    ];
                    return DocGenerado::where($where)
                        ->count();
                }
                break;
            case '12' :
                {
                    $where = [
                        ['oper_procesado', '=', 0],
                        ['oper_iddependencia', '=', Auth::user()->depe_id],
                        ['td.idtdoc', '<>', env("TIPO_DOC_PAPELETA")],
                        ['oper_idtope', '=', 2],
                        ['oper_idusuario', '=', Auth::user()->id],
                    ];
                }
                break;
            case '13' :
                {
                    $where = [
                        ['oper_iddependencia', '=', Auth::user()->depe_id],
                        ['oper_procesado', '=', 0],
                        ['oper_idtope', '<>', 1],
                        ['oper_idtope', '<>', 2],
                        ['oper_idusuario', '=', Auth::user()->id],
                        ['oper_tarchi_id', '=', 0],
                    ];
                    return Operacion::where($where)
                        ->count();
                }
                break;
            case '14' :
                {
                    $where = [
                        ['oper_procesado', '=', 0],
                        ['oper_iddependencia', '=', Auth::user()->depe_id],
                        ['td.idtdoc', '<>', env("TIPO_DOC_PAPELETA")],
                        ['oper_idtope', '<>', 3],
                        ['oper_idtope', '<>', 4],
                        ['docu_digital', true],
                    ];
                }
                break;
            case '15' :
                {
                    $where = [
                        ['oper_procesado', '=', 0],
                        ['oper_iddependencia', '=', Auth::user()->depe_id],
                        ['td.idtdoc', '<>', env("TIPO_DOC_PAPELETA")],
                        ['oper_idtope', '<>', 3],
                        ['oper_idtope', '<>', 4],
                        ['oper_idusuario', '=', Auth::user()->id],
                        ['docu_digital', true],
                    ];
                }
                break;
        }
        return Operacion::where($where)
            ->join('tram_documento as d', 'oper_iddocumento', '=', 'd.iddocumento')
            ->join('tram_tipodocumento as td', 'd.docu_idtipodocumento', '=', 'td.idtdoc')
            ->count();

    }

    public function obtenerTotal()
    {

        $arreglo = [
            "totalProceso"               => $this->countDocumento(1),
            "derivadosProceso"           => $this->countDocumento(2),
            "usuarioProceso"             => $this->countDocumento(3),
            "totalRecibir"               => $this->countDocumento(4),
            "usuarioRecibir"             => $this->countDocumento(5),
            "totalArchivado"             => $this->countDocumento(6),
            "usuarioArchivados"          => $this->countDocumento(7),
            // "totalPlantilla"             => $this->countDocumento(8),
            // "usuarioPlantilla"           => $this->countDocumento(9),
            // "totalDocGenerados"          => $this->countDocumento(10),
            // "usuarioDocGenerados"        => $this->countDocumento(11),
            "usuarioDerivadosProceso"    => $this->countDocumento(12),
            'usuariosArchivadosTemporal' => $this->countDocumento(13),
            'totalMpv'                   => $this->countDocumento(14),
            'usuariosMpv'                => $this->countDocumento(15),
        ];
        return response()->json((Object)$arreglo);
    }

    public function buscarModal($id)
    {

        return view('verDocumentoModal',['iddocumento'=>$id]);
    }
    public function buscarExpedienteModal($id)
    {

        return view('verExpedienteModal', ['iddocumento'=>$id]);
    }

    
    public function generatramitemesapartes(Request $request)
    {
        $iduser=Auth::user()->id;
        $iddepenencia=DB::table('admin')->where('id',$iduser)->value('depe_id');
        $clavedoc=Str::random(6);
        $fecha=date('Y-m-d');
        // cuando no existe el expediente se crea nuevo
            $documain=Tram_documentomain::create(['dmai_idusu'=>$iduser]);
            $expediente=$documain->iddocumentomain;

            $tramite=new Tram_documento();
            $tramite->docu_idexma= $expediente;
            $tramite->docu_idprioridad=1; 
            $tramite->docu_origen=2; // 1: interno, 2 externo
            $tramite->docu_tipo=0;
            $tramite->docu_iddependencia=$iddepenencia;// 2: usuario que pertenece a una dependencia
            $tramite->docu_firma=strtoupper($request->nombres);
            $tramite->docu_cargo=($request->tipo==1)?'PERSONA NATURAL':'PERSONA JURÍDICA';
            // $tramite->docu_detalle='';
            $tramite->docu_fecha_doc=$fecha;
            // $tramite->docu_siglas_doc='';
            $tramite->docu_numero_doc=0; 
            $tramite->docu_idusuario=$iduser;//1
            $tramite->docu_idusuariodependencia=$iddepenencia;// codigo de la unidad a donde pertenece el usuario
            $tramite->docu_idtipodocumento=18;// es 18 para gore cusco
            // $tramite->docu_proyectado='';
            $tramite->docu_idrecepcion=1;
            // $tramite->docu_folios=''; 
            // $tramite->docu_asunto=''; 
            $tramite->docu_clastupa=9; 
            // $tramite->docu_diasatencion=''; 
            $tramite->docu_dni=($request->tipo==1)?$request->numero:'';
            $tramite->docu_ruc=($request->tipo==0)?$request->numero:'';
            $tramite->docu_telef=$request->telefono;
            $tramite->docu_domic=strtoupper($request->direccion);
            // $tramite->docu_emailorigen='';
            $tramite->docu_referencias='[]'; 
            $tramite->docu_digital=0; 
            $tramite->docu_forma=0; 
            $tramite->docu_relacionado=0; 
            $tramite->docu_estado=1; 
            $tramite->docu_contrasenia=$clavedoc;

            $tramite->save();

            $op                 = new Operacion();
            $op->oper_iddocumento = $tramite->iddocumento;

                $op->oper_iddependencia = $iddepenencia;// codigo de la unidad a donde pertenece el usuario
                $op->oper_idusuario = $iduser;
                $op->oper_idtope    = 1;
                $op->oper_es_destino     = 1;
                $op->oper_forma     = 0;
                $op->oper_manual     = 0;
                //requeridos
                $op->oper_procesado = 0;// 0: cuando se ha creado sin derivaciones
                //$op->enviarSMS(); falta implementar
                $op->save();// la variable top guarda informacion el registro realizado
      
                return response()->json(['documento'=>$tramite->iddocumento,'expediente'=>$expediente], 200);
        
    }
}
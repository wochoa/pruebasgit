<?php

namespace App\Http\Controllers\Tramites;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Tram_documento;
use App\Models\Operacion;
use App\Models\Archivos;//File

class DocumentoController extends Controller
{
    public function __construct()
    {
        //Aqui se verifica si esta logueado
        $this->middleware('auth', ['except' => ['buscarexpediente', 'buscarDocumento','printPdf','buscardocumentofile']]);
    }

    public function buscardocumentofile(Request $request)
    {
        $doc=Tram_documento::where(['iddocumento'=>$request->iddocumento,'docu_contrasenia'=>$request->clave])->get();
        if(count($doc))
        {
            $file=Archivos::find($request->iddocumento);
            return url('/mostrararchivo/'.$file->id);
        }
        else{
            return response()->json([
                'status'=>0,
                'msg'=>'No se encontró el archivo digital con los datos ingresados',
                'tipo'=>'error'                
            ]);
        }

    }
    public function buscarDocumento(Request $request)
    {
        $documento = Tram_documento::select(
            [
                'iddocumento',
                'docu_idexma as expediente',
                'docu_origen',
                'docu_tipo',
                'tdo.tdoc_descripcion',
                'docu_numero_doc',
                'docu_siglas_doc',
                'docu_fecha_doc',
                'docu_folios',
                'docu_asunto',
                'docu_iddependencia',
                'td.depe_nombre as unidad',
                'td2.depe_nombre as dependencia',
                'docu_firma',
                'docu_cargo',
                'docu_domic',
                'docu_ruc',
                'docu_dni',
                'docu_idtipodocumento',
                'docu_idusuario',
                'docu_proyectado',
                'docu_emailorigen',
                'docu_telef',
            ])
            ->join('tram_tipodocumento as tdo', 'docu_idtipodocumento', '=', 'tdo.idtdoc')
            ->join('admin as a', 'docu_idusuario', '=', 'a.id')
            ->join('tram_dependencia as td', 'docu_iddependencia', '=', 'td.iddependencia')
            ->leftJoin('tram_dependencia as td2', 'td.depe_depende', '=', 'td2.iddependencia')
            ->where('iddocumento', $request->iddocumento)
            ->first();
        if ($request->only_document)
            return $documento;
        $relacionados = Tram_documento::select(
            [
                'iddocumento',
                'tdo.tdoc_descripcion',
                'docu_numero_doc',
                'docu_siglas_doc',
                'docu_asunto',
                'docu_archivo',
            ])
            ->join('tram_tipodocumento as tdo', 'docu_idtipodocumento', '=', 'tdo.idtdoc')
            ->join('tram_operacion', 'oper_iddocumento', '=', 'iddocumento')
            ->where('oper_iddocumento_adj', $request->iddocumento)
            ->get();

        $operaciones = Operacion::select([
            'td2.depe_abreviado as dependencia',
            'tram_operacion.created_at',
            DB::raw('(SELECT op.created_at FROM tram_operacion AS op WHERE op.oper_idprocesado = tram_operacion.idoperacion LIMIT 1) as fecha_procesado'),
            'tram_operacion.oper_idtope',
            'ta.arch_nombre',
            'ta.arch_periodo',
            'tram_operacion.oper_forma',
            'td.depe_nombre as unidad',
            'a.adm_name as nombre',
            'a.adm_lastname as apellido',
            'td3.depe_nombre as depe_destino',
            'td3.depe_representante as dest_representante',
            'a2.adm_name as adm_name_destino',
            'a2.adm_lastname as adm_lastname_destino',
            'tram_operacion.oper_detalledestino',
            'tram_operacion.oper_acciones',
            'tram_operacion.oper_iddocumento_adj',
            'tram_operacion.idoperacion',
            'tram_operacion.oper_procesado',
            'tram_operacion.oper_idprocesado',
        ])
            ->join('admin as a', 'tram_operacion.oper_idusuario', '=', 'a.id')
            ->join('tram_dependencia as td', 'tram_operacion.oper_iddependencia', '=', 'td.iddependencia')
            ->leftJoin('tram_dependencia as td2', 'td.depe_depende', '=', 'td2.iddependencia')
            ->leftJoin('tram_dependencia as td3', 'tram_operacion.oper_depeid_d', '=', 'td3.iddependencia')
            ->leftJoin('admin as a2', 'tram_operacion.oper_usuid_d', '=', 'a2.id')
            ->leftJoin('tram_archivador as ta', 'tram_operacion.oper_idarchivador', '=', 'ta.idarch')
            ->where('tram_operacion.oper_iddocumento', $request->iddocumento)
            ->orderBy('idoperacion', 'asc')
            ->get();
        $digitales   = Archivos::select('id', 'file_url', 'file_name', 'file_tipo', 'file_size', 'file_mostrar', 'file_principal', 'id_documento','created_at')
            ->where('id_documento', '=', $request->iddocumento)
            ->get();

        // la lista de las unidades
        $dependencias=DB::table('tram_dependencia')->whereNotNull('depe_sigla')->whereNotNull('depe_depende')->where('depe_estado',1)->orderBy('depe_nombre','asc')->get();

        return json_encode((Object)[
            "documento"    => $documento,
            "operaciones"  => $operaciones,
            'relacionados' => $relacionados,
            'digitales'    => $digitales,
            'dependencias'    => $dependencias,

        ]);
    }
    public function printPdf(Request $request)
    {

        $data = ($request->tipo == 1) ? $request->id_documento : $request->id_documento_externo;

        return Archivos::getPdf($request->id, $data, $request->tipo);
    }
    public function recepcionar(Request $request)
    {

        Operacion::recepcion($request->recibir, (Object)$request->derivaciones, $request->tipoDoc);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function generarObservacion(Request $request)
    {
        $r = Operacion::generarDocObservacion($request->idOperacion, (Object)$request->datoOperacion);
        return json_encode((Object)[
            'status' => $r,
            'msg'    => ($r) ? "Se registró correctamente la observación" : "hubo un problema al intentar realizar la operacion",
        ]);
    }
    public function documentoDerivar(Request $request)
    {
        $r = true;
        foreach ($request->operSelected as $idOpe) {
            $o = Operacion::find($idOpe);
            if ($o == null)
                Log::info('Error personalizado de Walther : ' . json_encode(['request' => $request->all()]));
            if (!Operacion::derivar2($o, (Object)$request->derivaciones))
                $r = false;
        }
        return json_encode((object)[
            'status' => $r,
            'msg'    => ($r) ? "la derivacion se hizo correctamente" : "hubo un problema al intentar grabar la derivacion",
        ]);
    }

    public function documentoArchivar(Request $request)
    {
        Operacion::docArchivarAdjuntar($request->idDocumento, (Object)$request->datoDocumento);
    }

    public function devolverProceso(Request $request)
    {
        $r = Operacion::devolverdocProceso($request->devolver);
        return json_encode((object)[
            'status' => $r,
            'msg'    => ($r) ? "la operacion se realizo correctamente" : "hubo un problema al intentar realizar la operacion",
        ]);
    }
    
    public function eliminarDerivacion(Request $request)
    {
        $r = Operacion::eliminarDocDerivacion($request->devolver);
        return json_encode((object)[
            'status' => $r,
            'msg'    => ($r) ? "la operación se realizo correctamente" : "hubo un problema al intentar realizar la operación",
        ]);
    }

    public function documentoAdjuntar(Request $request)
    {
        Operacion::docArchivarAdjuntar($request->idDocumento, (Object)$request->datoDocumento);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function buscarexpediente(Request $request)
    {
        return Tram_documento::select([
            'iddocumento',
            'docu_origen',
            'docu_fecha_doc',
            'td.tdoc_descripcion',
            'docu_numero_doc',
            'docu_siglas_doc',
            'docu_asunto',
            'docu_firma',
            'tde.depe_nombre',
            'docu_idexma',
        ])
            ->join('tram_tipodocumento as td', 'docu_idtipodocumento', '=', 'td.idtdoc')
            ->leftJoin('tram_dependencia as tde', 'docu_iddependencia', '=', 'tde.iddependencia')
            ->where('docu_idexma', '=', $request->iddocumento)
            ->orderBy('docu_fecha_doc', 'asc')
            ->get();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

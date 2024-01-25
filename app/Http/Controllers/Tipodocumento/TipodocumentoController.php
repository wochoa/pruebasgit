<?php

namespace App\Http\Controllers\Tipodocumento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use App\Models\TipoDocumentoCorrel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\TipoDocumento;

class TipodocumentoController extends Controller
{
    
    public function __construct()
    {
        //Aqui se verifica si esta logueado
        $this->middleware('auth', ['except' => ['mpv','index']]);

    }

    public function index()
    {
        $datos=DB::table('tram_tipodocumento')->orderBy('tdoc_descripcion','asc')->get();

      
        return ['listadoc'=>$datos];
    }
    public function tipoDocumento(Request $request)
    {
            $where              =[];
            if($request->tdoc_descripcion!=null)
                $where[]        =['tdoc_descripcion','LIKE',"%$request->tdoc_descripcion%"];

            return TipoDocumento::select(['idtdoc',
                'tdoc_descripcion',
                'tdoc_abreviado',
                'tdoc_mpv',
                'nombre_archivo'
            ])
                ->where($where)
                ->orderBy('idtdoc', 'asc')
                ->paginate(10);

    }

    public function buscatipodocumento($id,$tipotram)
    {
        $iduser=Auth::user()->id;//4295;// wilmer ochoa
        $idoficina=User::where('id',$iduser)->value('depe_id');
        //$idoficina=2;// sale del id usuario

        $anio=date('Y');
        $nombre_doc=DB::table('tram_tipodocumento')->where('idtdoc',$id)->value('tdoc_descripcion');
        $nombre_archivo=DB::table('tram_tipodocumento')->where('idtdoc',$id)->value('nombre_archivo');
        if($tipotram=='false')// cuando el usuario no selecciona personal(se tramite desde la oficina)
        {

            $correlativo=DB::table('tram_tipodocumento_correl')->where(['tdco_idtipodocumento'=>$id,'tdco_periodo'=>$anio,'tdco_iddependencia'=>$idoficina])->whereNull('tdco_idusuario')->orderBy('id','DESC')->limit(1)->value('tdco_numero');
        }
        else
        {   
            $correlativo=DB::table('tram_tipodocumento_correl')->where(['tdco_idtipodocumento'=>$id,'tdco_idusuario'=>$iduser,'tdco_periodo'=>$anio])->orderBy('id','DESC')->limit(1)->value('tdco_numero');
        }

        $datos=['nombre_doc'=>$nombre_doc,'correlativo'=>$correlativo,'nombre_archivo'=>$nombre_archivo];
        //
        return $datos;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       if($request->hasFile('archivo'))
       {
            $file=$request->file('archivo');
            $bombre=$request->tdoc_descripcion.'.'.$file->guessExtension();
            Storage::disk()->putFileAs('formatosdoc', $file, $bombre);
            $ruta='formatosdoc/'.$bombre;
       }
       else{
        $ruta='';
       }



        $tipoDocumento                          = ($request->idtdoc=='')?new TipoDocumento():TipoDocumento::find($request->idtdoc);
        $tipoDocumento->tdoc_descripcion        = $request->tdoc_descripcion;
        $tipoDocumento->tdoc_abreviado          = $request->tdoc_abreviado;
        $tipoDocumento->tdoc_correlativo        = $request->tdoc_correlativo;
        $tipoDocumento->tdoc_mpv                = $request->tdoc_mpv;
        $tipoDocumento->nombre_archivo          = $ruta;
        $tipoDocumento->save();
        
        return $ruta;

    }


    public function show($id)
    {
        return TipoDocumento::select(['idtdoc',
                                        'tdoc_descripcion',
                                        'tdoc_abreviado',
                                        'tdoc_correlativo',
                                        'tdoc_mpv',
                                        'nombre_archivo'])
                                ->where('idtdoc',$id)
                                ->first();
    }
    public function prueba()
    {
        $iduser=Auth::user()->id;//4295;// wilmer ochoa
        $idoficina=User::where('id',$iduser)->value('depe_id');
        return $idoficina;
    }

    public function correlativos(Request $request)
    {
       
            $where              =[];
            if($request->tdco_periodo!=null)
                $where[]        =['tdco_periodo','=',$request->tdco_periodo];
            if($request->iddependencia!=null)
                $where[]        =['td.iddependencia','=',$request->iddependencia];
            if($request->idadmin!=null)
                $where[]        =['ad.id','=',$request->idadmin];
            if($request->idtdoc!=null)
                $where[]        =['tdo.idtdoc','=',$request->idtdoc];
             
             $correlativos= TipoDocumentoCorrel::select(['tram_tipodocumento_correl.id',
                                                        'tdco_periodo',
                                                        'td.depe_nombre', 
                                                        'tdo.tdoc_descripcion',
                                                        DB::raw("CONCAT(ad.adm_name,' ',ad.adm_lastname) as adm_email"),
                                                        'tdco_numero'])    
                                                ->join('tram_dependencia as td', 'tram_tipodocumento_correl.tdco_iddependencia', '=', 'td.iddependencia')                 
                                                ->join('tram_tipodocumento as tdo', 'tram_tipodocumento_correl.tdco_idtipodocumento', '=', 'tdo.idtdoc')
                                                ->leftJoin('admin as ad', 'ad.id','=','tram_tipodocumento_correl.tdco_idusuario')
                                                ->where($where)                 
                                                ->orderBy('tdco_periodo','ASC')
                                                //->orderBy('td.depe_nombre','ASC')
                                                ->orderBy('tdo.tdoc_descripcion', 'asc')
                                                ->orderBy('ad.id', 'asc')                 
                                                ->paginate(15);
            return $correlativos;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function mpv()
    {
        return TipoDocumento::where('tdoc_mpv',1)
            ->orderBy('tdoc_descripcion','asc')
            ->get();
    }
    public function interno()
    {
        return TipoDocumento::select(['idtdoc','tdoc_descripcion'])
            ->where('tdoc_mpv',0)
            ->orderBy('tdoc_descripcion','asc')
            ->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $correlativo                    =TipoDocumentoCorrel::find($id);
        $correlativo->tdco_numero       =$request->tdco_numero;
        $correlativo->save();
        
        return $correlativo;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $idcorrelativo=$request->id;

        $correlativo                    =TipoDocumentoCorrel::find($idcorrelativo);
        $correlativo->delete();
        return response()->json(['respuesta'=>'Fue eliminado el correlativo'], 200);
    }
}

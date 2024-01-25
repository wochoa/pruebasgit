<?php

namespace App\Http\Controllers\Tramites;

use App\Http\Controllers\Controller;
use App\Models\DocumentoExterno;
use Illuminate\Support\Facades\Storage;
use App\Models\Archivos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Mesapartesvirtual extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth' => 'verified'])->except("index",'documentosdigitales','editmpv','buscarmpv','mensajempv');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('layouts.plantillablanco');
    }
    public function documentosdigitales()
    {
        return view('layouts.plantillablanco');
    } 
    public function editmpv($id,$token)
    {
        return view('layouts.plantillablanco');
    }
    public function buscarmpv(Request $request)
    {
        $datos=DocumentoExterno::where(['id'=>$request->id,'docu_token'=>$request->token,'docu_estado'=>1])->get();
        $archivos=Archivos::where(['id_documento_externo'=>$request->id])->get();
        if(count($datos)>0){
            return response()->json(['document'=>$datos,'files'=>$archivos,'status'=>1,'msg'=>'Su documento se encuentra observado','tipo'=>'warning'],200); 
        }
        else{
            return response()->json(['document'=>$datos,'files'=>$archivos,'status'=>0,'msg'=>'Su documento está pendiente de atención','tipo'=>'info'],200);
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function eliminarfile(Request $request)
    {
        $file=Archivos::find($request->id);
        $rutaDelarchivo=$file->file_url;
        $arraynombrepdf = explode('/', $rutaDelarchivo);
        $nombrearchivo=$arraynombrepdf[6];
        

        // Storage::delete($nombrearchivo);
        if(Storage::exists($file->file_url)){
            Storage::delete($file->file_url);
            $file->delete();
            return response()->json([
                'msg'=>'Fue eliminado con éxito',
                'tipo'=>'success'
            ]);
        }
        else{
            return response()->json([
                'msg'=>'No se pudo eliminar el archivo',
                'tipo'=>'warning'
            ]);
        }

        // return $nombrearchivo;
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function mensajempv()
    {
        $text=DB::table('mpvcomunicado')->value('textmpv');
        return response()->json(['data'=>$text]);
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

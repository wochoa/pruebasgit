<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Depedencia;

class DepedendenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datos=DB::table('tram_dependencia')->whereNull('depe_sigla')->where('depe_tipo',0)->orderBy('iddependencia','asc')->paginate(10);

        return [
            'paginacion'=>[
                'total'=>$datos->total(),
                'current_page'=>$datos->currentPage(),// pagina actual
                'per_page'=>$datos->perPage(),// por pagina
                'last_page'=>$datos->lastPage(),//ultima pagina
                'from'=>$datos->firstItem(),// desde
                'to'=>$datos->total(),// hasta
            ],
            'listadepe'=>$datos
        ];
    }
    public function listardepeexterno()
    {
        $datos=DB::table('tram_dependencia')->whereNull('depe_sigla')->where('depe_tipo',2)->orderBy('iddependencia','asc')->paginate(10);

        return [
            'paginacion'=>[
                'total'=>$datos->total(),
                'current_page'=>$datos->currentPage(),// pagina actual
                'per_page'=>$datos->perPage(),// por pagina
                'last_page'=>$datos->lastPage(),//ultima pagina
                'from'=>$datos->firstItem(),// desde
                'to'=>$datos->total(),// hasta
            ],
            'listadepe'=>$datos
        ];
    }
    public function listardepeexternosinpg()
    {
        $datos=DB::table('tram_dependencia')->whereNull('depe_sigla')->where('depe_tipo',2)->orderBy('iddependencia','asc')->get();

        return $datos;
    }

    public function busdepedencia($id)
    {
        $datos=Depedencia::where('iddependencia',$id)->get();
        return $datos;
    }

    public function oficinas($coddepe)
    {
        $datos=DB::table('tram_dependencia')->where('depe_depende',$coddepe)->orderBy('iddependencia','asc')->paginate(10);
        $nomdepe=DB::table('tram_dependencia')->where('iddependencia',$coddepe)->value('depe_nombre');

        return [
            'paginacion'=>[
                'total'=>$datos->total(),
                'current_page'=>$datos->currentPage(),// pagina actual
                'per_page'=>$datos->perPage(),// por pagina
                'last_page'=>$datos->lastPage(),//ultima pagina
                'from'=>$datos->firstItem(),// desde
                'to'=>$datos->total(),// hasta
            ],
            'listadepe'=>$datos,
            'nombre_dependencia'=>$nomdepe
        ];
    }

    public function unidad($coddepe)
    {
        $nomdepe=DB::table('tram_dependencia')->where('iddependencia',$coddepe)->get();
        return response()->json($nomdepe);
    }

    public function nombredepe($coddepe)
    {
        $nomdepe=DB::table('tram_dependencia')->where('iddependencia',$coddepe)->value('depe_nombre');
        return $nomdepe;
    }
    public function nombredepexuser()
    {
        $id=Auth::user()->id;
        $depme=User::where('id',$id)->value('depe_id');
        $iddepe_sup=Depedencia::where('iddependencia',$depme)->value('depe_depende');
        $nomdepe=Depedencia::where('iddependencia',$iddepe_sup)->value('depe_nombre');

        return $nomdepe;
    }
    public function nuevodependencia(Request $request)
    {
        // $datos=$request->all();
        $depe=new Depedencia();

        $depe->depe_nombre=strtoupper($request->nomdepe); 
        $depe->depe_abreviado=strtoupper($request->abreviatura); 
        $depe->depe_estado=$request->estado; 
        $depe->depe_ciudad=strtoupper($request->ciudad); 
        $depe->depe_direccion=strtoupper($request->direccion); 
        $depe->depe_agente=0; 
        $depe->depe_tipo=$request->externo; 
        $depe->depe_proyectado=0; 
        $depe->depe_mesa_virtual=0; 
        $depe->save();
        return $depe;
    }
    public function dependenciaupdate(Request $request)
    {
        // $datos=$request->all();
        $depe=Depedencia::find($request->iddepe);

        $depe->depe_nombre=strtoupper($request->nomdepe); 
        $depe->depe_abreviado=strtoupper($request->abreviatura); 
        $depe->depe_estado=$request->estado; 
        $depe->depe_ciudad=strtoupper($request->ciudad); 
        $depe->depe_direccion=strtoupper($request->direccion); 
        $depe->save();
        return $depe;
    }
    public function oficinanueva(Request $request)
    {
        // $datos=$request->all();

  
        $depe=new Depedencia();

        $depe->depe_nombre=strtoupper($request->nombre_oficina); 
        $depe->depe_depende=$request->depe_depe; 
        $depe->depe_abreviado=strtoupper($request->abreviado); 
        $depe->depe_sigla=strtoupper($request->siglas); 
        $depe->depe_representante=strtoupper($request->representante); 
        $depe->depe_dni=$request->dni; 
        $depe->depe_cargo=strtoupper($request->cargo); 
        $depe->depe_estado=$request->estado; 
        $depe->depe_recibetramite=$request->recibetramite; 
        $depe->depe_agente=0; 
        $depe->depe_tipo=1; 
        $depe->depe_proyectado=1; 
        $depe->depe_mesa_virtual=$request->mpv;
        $depe->depe_diasmaxenproceso=$request->diasmaxenproceso;
        $depe->depe_observaciones=strtoupper($request->observaciones);
        $depe->save();


        if ($request->hasFile('cabecera')) {
            $nombre= $depe->iddependencia.'-C.'.$request->cabecera->getClientOriginalExtension();
            $ubiacionfile_p='encabezado/'.$nombre;
            Storage::disk()->putFileAs('', $request->cabecera, $ubiacionfile_p);
    
            $patch=Storage::path($ubiacionfile_p);
            $cabeza=$ubiacionfile_p;
        }
        else{
            $cabeza='';
        }   



        if ($request->hasFile('footer')) {
            // $foo_ter = $request->footer->store('encabezado');
            $nombre= $depe->iddependencia.'-F.'.$request->footer->getClientOriginalExtension();
            $ubiacionfile_p='encabezado/'.$nombre;
            Storage::disk()->putFileAs('', $request->footer, $ubiacionfile_p);
    
            $patch=Storage::path($ubiacionfile_p);
            $foo_ter=$ubiacionfile_p;
        }
        else{
            $foo_ter='';
        }

        $upd=Depedencia::find($depe->iddependencia);
        $upd->depe_imagen_header=$cabeza;
        $upd->depe_imagen_footer=$foo_ter;
        $upd->save();

        return $depe;
    }
    public function oficinaupdate(Request $request)
    {
        $depe=Depedencia::find($request->idoficina);
        $depe->depe_nombre=strtoupper($request->nombre_oficina); 
        $depe->depe_depende=$request->depe_depe; 
        $depe->depe_abreviado=strtoupper($request->abreviado); 
        $depe->depe_sigla=strtoupper($request->siglas); 
        $depe->depe_representante=strtoupper($request->representante); 
        $depe->depe_dni=$request->dni; 
        $depe->depe_cargo=strtoupper($request->cargo); 
        $depe->depe_estado=$request->estado; 
        $depe->depe_recibetramite=$request->recibetramite; 
        $depe->depe_agente=0; 
        $depe->depe_tipo=1; 
        $depe->depe_proyectado=1; 
        $depe->depe_mesa_virtual=$request->mpv;
        $depe->depe_diasmaxenproceso=$request->diasmaxenproceso;
        $depe->depe_observaciones=strtoupper($request->observaciones);

        if ($request->hasFile('cabecera')) {
            $nombre= $request->idoficina.'-C.'.$request->cabecera->getClientOriginalExtension();
            $ubiacionfile_p='encabezado/'.$nombre;
            Storage::disk()->putFileAs('', $request->cabecera, $ubiacionfile_p);
    
            $patch=Storage::path($ubiacionfile_p);
            $cabeza=$ubiacionfile_p;
        }
        else{
            $cabeza=$request->cabecera;
        }   



        if ($request->hasFile('footer')) {
            // $foo_ter = $request->footer->store('encabezado');
            $nombre= $request->idoficina.'-F.'.$request->footer->getClientOriginalExtension();
            $ubiacionfile_p='encabezado/'.$nombre;
            Storage::disk()->putFileAs('', $request->footer, $ubiacionfile_p);
    
            $patch=Storage::path($ubiacionfile_p);
            $foo_ter=$ubiacionfile_p;
        }
        else{
            $foo_ter=$request->footer;
        }
        $depe->depe_imagen_header=$cabeza;
        $depe->depe_imagen_footer=$foo_ter;

        $depe->save();
        return $depe;
    }

    public function alldependencia()
    {
        $datos=DB::table('tram_dependencia')->orderBy('iddependencia','asc')->get();
        return  response()->json($datos, 200);
    }

    public function dependenciaMesaPartesVirtual()
    {
        return Depedencia::select('tram_dependencia.iddependencia', 'tram_dependencia.depe_nombre')
            ->where('tram_dependencia.depe_tipo', '=', 0)
            ->where('td2.depe_mesa_virtual', '=', 1)
            ->join('tram_dependencia AS td2', 'tram_dependencia.iddependencia', '=', 'td2.depe_depende')
            ->orderBy('depe_nombre', 'asc')
            ->groupBy('tram_dependencia.iddependencia')
            ->groupBy('tram_dependencia.depe_nombre')
            ->get();
    }

    public function obtenerMiUnidadOrganica()
    {
        return Depedencia::select('iddependencia',
            'depe_nombre',
            'depe_depende',
            'depe_representante',
            'depe_cargo',
            'depe_sigla')
            ->where('iddependencia',Auth::user()->depe_id)
            ->orderBy('depe_nombre','ASC')
            ->first();
    }
    public function obtenerUnidadOrganica(Request $request)
    {
        //\Debugbar::disable();

        switch ($request->tipo){
            case '5' :{
                //obtener datos de una unidad Organia en especifico OJO datos completos
                return $this->obtenerMiUnidadOrganica();
            }break;
            default :{
                //obtener datos de una unidad Organia en especifico OJO datos completos
                $d = Depedencia::select('iddependencia',
                    'depe_nombre',
                    'depe_depende',
                    'depe_tipo',
                    'depe_recibetramite',
                    'depe_mesa_virtual')
                    ->orderBy('depe_nombre','ASC')
                    ->get();
                $r=[];
                foreach ($d as $f){
                    $r[]=(Object)[$f->iddependencia,$f->depe_nombre,$f->depe_depende,$f->depe_tipo,$f->depe_recibetramite,$f->depe_mesa_virtual];
                }
                return $r;
            }break;
        }

    }

    public function unidades(Request $request)
    {

        $dependencias=Depedencia::find(Auth::user()->depe_id);

        $where              =[];
        if ($request->depe_representante!=null)
            $where[]        =['tram_dependencia.depe_representante','LIKE',"%$request->depe_representante%"];
        if ($request->depe_nombre!=null)
            $where[]        =['tram_dependencia.depe_nombre','LIKE',"%$request->depe_nombre%"];
        if ($request->depe_depende!=null && $request->tipo==1)//1 nivel superadmin puede buscar por dependencia
            $where[]        =['tram_dependencia.depe_depende','=',$request->depe_depende];
        if ($request->depe_depende!=null && $request->tipo==2)
            $where[]        =['tram_dependencia.depe_depende','=',$dependencias->depe_depende];
        if ($request->iddependencia!=null)
            $where[]        =['tram_dependencia.iddependencia','=',$request->iddependencia];

        return Depedencia::select('tram_dependencia.iddependencia',
                                    'tram_dependencia.depe_nombre',
                                    'tram_dependencia.depe_abreviado',
                                    'tram_dependencia.depe_sigla',
                                    'tram_dependencia.depe_representante',
                                    'td2.depe_nombre AS nombre')
                            ->join('tram_dependencia AS td2', 'tram_dependencia.depe_depende', '=', 'td2.iddependencia')
                            ->where($where)
                            ->orderBy('tram_dependencia.iddependencia', 'asc')
                            ->paginate(15);

    }
}

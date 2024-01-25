<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use App\Models\Trampersona;
use App\Models\Trampersonajuridica;

use Illuminate\Http\Request;

class Reniecsunat extends Controller
{
    public function __construct()
    {
        //Aqui se verifica si esta logueado
        $this->middleware('auth', ['except' => ['reniec','sunat','updatetelenocorreo']]);

    }
    public function reniec(Request $request)
    {
        // $response = Http::get('https://api.apis.net.pe/v1/dni', [
        //     'numero' => $dni,
        // ]);
        $dni=$request->dni;
        if(strlen($dni)==8){

            // aqui buscamos si la persona se encuentra en bd, de no se asi recien hacemos busqueda en api 
            $busca=Trampersona::where('dni',$dni)->get();
            if(count($busca)>0)
            {
                return $busca[0];
            }
            else{
                $response = Http::get('http://app.regionhuanuco.gob.pe/soap_pruebas/reniec.php', [
                    'cdni' => $dni,
                ]);
                $datos= json_decode($response);
                $persona = new Trampersona();
                $persona->apPrimer=$datos->apPrimer;
                $persona->apSegundo=$datos->apSegundo;
                $persona->direccion=$datos->direccion;
                $persona->estadoCivil=$datos->estadoCivil;
                $persona->foto=$datos->foto;
                $persona->prenombres=$datos->prenombres;
                $persona->restriccion=$datos->restriccion;
                $persona->ubigeo=$datos->ubigeo;
                $persona->id = $dni;
                $persona->dni = $dni;
                $persona->save();

                return $datos;
            }
           
        }
        else{
            return response()->json(['error'=>'Para el DNI debe ser 8 digitos como mínimo']);
        }
        
    }
    public function sunat(Request $request)
    {
        // $response = Http::get('https://api.apis.net.pe/v1/ruc', [
        //     'numero' => $sunat,
        // ]);
        $sunat=$request->ruc;
        if(strlen($sunat)==11){

            $busca=Trampersonajuridica::where('ddp_numruc',$sunat)->get();
            if(count($busca)>0)
            {
                return $busca[0];
            }
            else{
                 // aqui buscamos si la persona se encuentra en bd, de no se asi recien hacemos busqueda en api
                $response = Http::get('http://app.regionhuanuco.gob.pe/soap_pruebas/datossunat.php', [
                    'cruc' => $sunat,
                ]);
                

                $datos= (array)json_decode($response);//json_decode($response);
                
                $persona = Trampersonajuridica::create($datos);

                return $datos;


            }

            
        }
        else{
            return response()->json(['error'=>'Para el RUC debe ser 11 digitos como mínimo']); 
        }
        
    }

    public function updatetelenocorreo(Request $request)
    {
        if($request->tipo==1){//1: RENIEC
            $busca=Trampersona::find($request->numero);
            $busca->telefono=$request->docu_telef;
            $busca->correo=$request->correo;
            $busca->save();

        }
        else{//0: RUC
            $busca=Trampersonajuridica::where('ddp_numruc',$request->numero)->first();
            $busca->telefono=$request->docu_telef;
            $busca->correo=$request->correo;
            $busca->save();
        }
    }


}

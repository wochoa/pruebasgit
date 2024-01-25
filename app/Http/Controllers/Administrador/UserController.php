<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Usuario_Oficina;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Models\Trampersona;
use App\Models\Depedencia;

class UserController extends Controller
{
    public function __construct()
    {
        //Aqui se verifica si esta logueado
        $this->middleware('auth', ['except' => ['persona']]);

        
    }
    public function index(Request $request)
    {
        // $datos=DB::table('userofi')->whereNotNull('adm_inicial')->orderBy('id','asc')->paginate(10);
        $user=Auth::user()->id;
        $codunidad=User::where('id',$user)->value('depe_id');

        // la dependencia donde pertenece el user :sede central, gerctur,etc

        $dependencia=Depedencia::where('iddependencia',$codunidad)->value('depe_depende');
        $user=Auth::user();     
        $where = [];
        if($user->hasAnyRole('ADMINISTRADOR'))
        {
            $where[] = ['td1.depe_depende', '=', "$dependencia"];  
        }


        if ($request->id != null)
            $where[] = ['admin.id', '=', "$request->id"];
        
            if ($request->id != null)
            $where[] = ['admin.id', '=', "$request->id"];
        if ($request->adm_dni != null)
            $where[] = ['adm_dni', '=', "$request->adm_dni"];
        if ($request->adm_name != null)
            $where[] = ['adm_name', 'LIKE', "%$request->adm_name%"];
        if ($request->adm_lastname != null)
            $where[] = ['adm_lastname', 'LIKE', "%$request->adm_lastname%"];
        if ($request->adm_estado != null)
            $where[] = ['adm_estado', '=', "$request->adm_estado"];
        if ($request->depe_id != null)
            $where[] = ['userofi.depe_id', '=', "$request->depe_id"];
        
            return DB::table('userofi')->select([
                'userofi.id',
                'adm_name',
                'adm_lastname',
                'adm_cargo',
                'adm_email',
                'adm_correo',
                'td1.depe_nombre as oficina',
                'adm_estado',
                'adm_dni',
            ])
                ->join('tram_dependencia as td1', 'userofi.depe_id', '=', 'td1.iddependencia')
                ->where('id', '<>', 1)
                ->where($where)
                ->orderBy('id', 'asc')
                ->paginate(15);


        // return $datos;
    }
    
    public function alluser()
    {
        $datos=DB::table('userofi')->whereNotNull('adm_inicial')->orderBy('id','asc')->get();
        return response()->json($datos, 200);
    }

    public function buscar($id)
    {

            $datos=User::whereNotNull('adm_inicial')->where('id',$id)->first();

            $foto=Trampersona::where('dni',$datos->adm_dni)->value('foto');
            // $useroficina=Usuario_Oficina::where('id',$id)->get();
            $useroficina=DB::table('usuario_oficinas')->join('admin','usuario_oficinas.iduser','=','admin.id')->join('tram_dependencia','usuario_oficinas.idunidad','=','tram_dependencia.iddependencia')->where(['admin.id'=>$id,'estado'=>1])->get();

            $roles=DB::table('model_has_roles')->join('roles','model_has_roles.role_id','=','roles.id')->select('name')->where('model_id',$id)->get();
            for($i=0;$i<count($roles);$i++)
            {
                $rol[]=$roles[$i]->name;
            }
            
            //return response()->json($datos);
            return response()->json(['datos'=>$datos,'foto'=>$foto,'oficinas'=>$useroficina,'rolesuser'=>$rol]);
       
    }

    public function nombreuser($id)
    {
        $datos=User::whereNotNull('adm_inicial')->where('id',$id)->get();//value('adm_name');
        $nombre=$datos[0]->adm_name;
        $apellidos=$datos[0]->adm_lastname;//User::whereNotNull('adm_inicial')->where('id',$id)->value('adm_lastname');
        $nombresyape=$nombre.' '.$apellidos;
        
            return response()->json($nombresyape, 200);

    }

    public function listauserdepe($id)
   {
       $usuarios=DB::table('userofi')->where(['depe_id'=>$id,'adm_estado'=>1])->orderBy('adm_name','asc')->get();
       $representante=DB::table('tram_dependencia')->where('iddependencia',$id)->get();

       return ['usuarios'=>$usuarios,'representantes'=>$representante];
   }

   public function detalleuserderivacion($id)
   {
       $usuario=User::where(['id'=>$id,'adm_estado'=>1])->get();
       return response()->json(['detalleuser'=>$usuario]);
   }

   public function usuariosunidad($depe)// lista de usuarios en la oficina o unidad organica
   {
        $id=Auth::user()->id;
        // $idsuser=Usuario_Oficina::join('','','','')
        $datos=Usuario_Oficina::join('admin','usuario_oficinas.iduser','=','admin.id')->where(['idunidad'=>$depe,'estado'=>1])->get();
        $busquedacargo=Usuario_Oficina::where(['idunidad'=>$depe,'iduser'=>$id,'estado'=>1])->first();

        $up=User::find($id);
        $up->depe_id=$depe;
        $up->adm_cargo=$busquedacargo->cargo;
        $up->save();

        // $usuarios=User::where(['depe_id'=>$id,'adm_estado'=>1])->orderBy('adm_name','asc')->get();
        return $datos;
   }
   public function obtenerUserDependenciaActivo(Request $request)
   {
       return DB::table('userofi')->where(['depe_id'=>$request->depe_id,'adm_estado'=>1])->where('adm_email','<>','SUPERADMIN')->get();

   }
   public function obtenerUserDependenciaActivoreport(Request $request)
   {
       switch ($request->tipo) {

           case '4' :
               {
                   $where = [
                       ['depe_id', '=', $request->depe_id],
                       ['adm_email', '<>', 'ADMIN'],
                   ];
                   return DB::table('userofi')->select([
                       'id',
                       DB::raw("CONCAT(adm_name,' ',adm_lastname) as adm_name"),
                       'adm_cargo',
                       'adm_inicial',
                   ])
                       ->where($where)
                       ->orderBy('adm_name', 'ASC')
                       ->get();
               }
               break;
           case '5' :
               {
                   $where = [
                       ['depe_id', '=', $request->depe_id],
                       ['adm_email', '<>', 'ADMIN'],
                       ['adm_estado', 1],
                   ];
                   return DB::table('userofi')->select([
                       'id',
                       DB::raw("CONCAT(adm_name,' ',adm_lastname) as adm_name"),
                       'adm_cargo',
                       'adm_inicial',
                   ])
                       ->where($where)
                       ->orderBy('adm_name', 'ASC')
                       ->get();
               }
               break;

           case '6' :
               {
                   $where = [
                       ['id', Auth::user()->id],
                   ];
                   return DB::table('userofi')->select(['id',
                       'adm_name',
                       'adm_lastname'])
                       ->where($where)
                       ->first();
               }
               break;
           case '7' :
                   {
                       $where = [
                           ['td1.depe_depende', '=', $request->depe_depende],
                           ['adm_email', '<>', 'ADMIN'],
                           ['adm_estado', 1],
                       ];
                       if ($request->iddependencia != null) {
                           $where[] = ['depe_id', $request->iddependencia];
                       }
                       return DB::table('userofi')->select([
                           'id',
                           DB::raw("CONCAT(adm_name,' ',adm_lastname) as adm_name"),
                           'adm_dni',
                           'td1.depe_nombre as depe_nombre',
                       ])
                           ->join('tram_dependencia as td1', 'depe_id', '=', 'td1.iddependencia')
                           ->where($where)
                           ->orderBy('td1.depe_nombre', 'asc')
                           ->orderBy('adm_name','asc')
                           ->paginate(20);
                   }
                   break;
           default :
           {
               $user = DB::table('userofi')->select([
                   'id',
                   DB::raw("CONCAT(adm_name,' ',adm_lastname) as adm_name"),
                   'adm_cargo',
                   'adm_inicial',
                   'adm_estado',
               ])
                   ->where('depe_id', '=', Auth::user()->depe_id)
                   ->where('adm_email', '<>', 'ADMIN')
                   ->orderBy('adm_name', 'ASC')
                   ->get();
               $us = [];
               foreach ($user as $u) {
                   $us[] = (Object)[$u->id, $u->adm_name, $u->adm_cargo, $u->adm_inicial, $u->adm_estado];
               }
               return $us;

           }
       }

   }

   public function oficinasdelusuario()// lista de oficina a que pertenece el user
   {
        $id=Auth::user()->id;

        $datos=DB::table('usuario_oficinas')->join('admin','usuario_oficinas.iduser','=','admin.id')->join('tram_dependencia','usuario_oficinas.idunidad','=','tram_dependencia.iddependencia')->where(['admin.id'=>$id,'estado'=>1])->get();
        return $datos;
   }

   public function cerrarsesion()
   {
    $id=Auth::user()->id;
    $up=User::find($id);
    $up->depe_id=0;
    $up->save();

    Auth::logout();
        return response()->json([
            'code'=>204
        ]);
   }

   public function datouserlogeado()
   {
    $usuario=Auth::user();
    return $usuario;
   }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function duplicado($dni)
    {
        $datos=User::where('adm_dni',$dni)->value('id');
        if($datos)
        {
            return response()->json([
                                        'status'=>1
                                    ]); 
        }
        else{
            return response()->json([
                                        'status'=>0
                                    ]);
        }

    }

    public function nuevousuario(Request $request)
    {
        // $datos=$request->all();
        $user=new User();
        $user->adm_name=strtoupper($request->adm_name);
        $user->adm_lastname=strtoupper($request->adm_lastname);
        $user->adm_inicial=strtoupper($request->adm_inicial);
        $user->adm_email=strtoupper($request->adm_dni);
        $user->adm_password=bcrypt($request->adm_password);
        $user->adm_estado=$request->adm_estado;
        $user->adm_cargo=strtoupper($request->adm_cargo);
        $user->adm_correo=strtoupper($request->adm_correo);
        $user->depe_id=$request->depe_id;
        $user->adm_vigencia=$request->adm_vigencia;
        $user->adm_observacion=strtoupper($request->adm_observacion);
        $user->adm_telefono=$request->adm_telefono;
        $user->adm_direccion=strtoupper($request->adm_direccion);
        $user->adm_dni=$request->adm_dni;
        $user->adm_con_especialidad=strtoupper($request->adm_con_especialidad);
        $user->adm_dni=$request->adm_dni;

        $user->save();

        $userupdate=Auth::user()->id;

        $roles=(array)$request->rolesasignado;

        $userof=new Usuario_Oficina();
        $userof->iduser=$user->id;
        $userof->idunidad=$request->depe_id;
        $userof->userupdate=$userupdate;
        $userof->acceso=$roles[0];
        $userof->cargo=strtoupper($request->adm_cargo);
        $userof->estado=$request->adm_estado;
        $userof->save();

        // $roles=(array)$request->rolesasignado;

        if(count($roles))
        {
            for($i=0;$i<count($roles);$i++)
            {
                $user->assignRole($roles[$i]);
            }
        }

        // $user->assignRole($request->rolesasignado);

        return $user;
    }

    public function actualizapassword(Request $request)
    {
        $id=Auth::user()->id;
        $user=User::find($id);
        // $ingresado=bcrypt($request->actual);

        // if($user->adm_password==$ingresado)
        // {
            $user->adm_password=bcrypt($request->nueva);
            $user->save();
            return response()->json([
                'status'=>1,
                'msg'=>'Fue actualizado su contraseña exitosamente',
                'tipo'=>'success'
            ]);
        // }
        // else{// cuando no concuerda
        //     return response()->json([
        //         'status'=>0,
        //         'msg'=>'En el campo de contraseña actual ingresado no concuerda con los registros de BD',
        //         'tipo'=>'error'
        //     ]);
        // }
        
    }
    public function updateoficinauser(Request $request)
    {
        // $datos=$request->all();
        // return $datos;
        $dat=Usuario_Oficina::find($request->idofiuser);
        $dat->estado=$request->estado;
        $dat->save();
    }
    public function nuevaasignacion(Request $request)
    {
        $id=Auth::user()->id;

        if(!$request->iduserof){ // si es nuevo la asignacion
            $nueva=new Usuario_Oficina();
            $nueva->iduser=$request->iduser;
            $nueva->idunidad=$request->idunidad;
            $nueva->userupdate=$id;
            $nueva->acceso=$request->acceso;
            $nueva->cargo=strtoupper($request->cargo);
            $nueva->estado=$request->estado;
            $nueva->save();
        }
        else{// si es para editar
            $dat=Usuario_Oficina::find($request->iduserof);
            $dat->iduser=$request->iduser;
            $dat->idunidad=$request->idunidad;
            $dat->userupdate=$id;
            $dat->acceso=$request->acceso;
            $dat->cargo=strtoupper($request->cargo);
            $dat->save();

            $up=User::find($id);
            $up->depe_id=0;
            $up->save();
        }
    }
    public function estadouser(Request $request)
    {
        $usr=User::find($request->id);
        $usr->adm_estado=$request->estado;
        $usr->save();
        return $usr;

    }
    public function buscauserofi($id)
    {
        $datos=Usuario_Oficina::find($id);
        return $datos;
    }
    public function actualizauser(Request $request)
    {
        $usr=User::find($request->id);
        $usr->adm_name=strtoupper($request->adm_name);
        $usr->adm_lastname=strtoupper($request->adm_lastname);
        $usr->adm_cargo=strtoupper($request->adm_cargo);
        $usr->adm_estado=$request->adm_estado;
        $usr->adm_dni=$request->adm_dni;
        $usr->adm_correo=$request->adm_correo;
        $usr->adm_vigencia=$request->adm_vigencia;
        $usr->adm_direccion=strtoupper($request->adm_direccion);
        $usr->adm_telefono=$request->adm_telefono;
        $usr->adm_inicial=strtoupper($request->adm_inicial);
        $usr->save();

        // eleiminamos los roles asignados anteriormente al user
        // DB::delete('delete from model_has_roles where model_id=?',$request->id);
        DB::delete('delete from model_has_roles where model_id = ?',[$request->id]);
        // DB::table('model_has_roles')->whereIn('model_id', $request->id)->delete();

        $roles=(array)$request->roles;

        if(count($roles))
        {
            for($i=0;$i<count($roles);$i++)
            {
                $usr->assignRole($roles[$i]);
            }
        }
        
        // $persona = User::where('id',$request->iduser)->update($datos);

        return $roles;

    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Firmaperu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Models\Archivos;
use Illuminate\Support\Facades\Storage;

class FirmaperuController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth' => 'verified'])->except('generatoken','devuelvetoken','parametrogral','parametrofirma','firmadorperu','versesion');
    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function generatoken()
    {
        
        $reg=Firmaperu::count('token');
        if($reg==0)// cuando se crea por primera vez
        {

            $response=$this->devuelvetoken();

            $newtoken=new Firmaperu();
            $newtoken->token=$response;
            $dateTimeNow = Carbon::now();
            //This will add 24 hours from now
            $dateTimeNew = Carbon::now()->addHour(23);
            $newtoken->updated_at=$dateTimeNew;
            $newtoken->save();
            $token=$newtoken->token;// retornamos el token registrado
        }
        else{// cuando ya existe el token en la bd registrado

            $hoy = Carbon::today(); //Aquí se obtiene la fecha de hoy para hacer comprobaciones menores a 24 horas que dura el token
            // $fechareg=Firmaperu::value('updated_at');// fecha actualizada de la ultima actualizacion del token
            // comparamos que tonken no se pase 
            $id=Firmaperu::limit(1)->value('id');
            $token=Firmaperu::whereDate('updated_at','>',$hoy)->value('token');
            
            if(!$token)
            {
                $response=$this->devuelvetoken();

                $updtoken=Firmaperu::find($id);
                $updtoken->token=$response;
                $dateTimeNow = Carbon::now();
                //This will add 24 hours from now
                $dateTimeNew = Carbon::now()->addHour(23);
                $updtoken->updated_at=$dateTimeNew;
                $updtoken->save();
                $token=$updtoken->token;// retornamos el token registrado 
            }

        }

        return $token;
    }
     public function devuelvetoken()
     {

        $response = Http::asForm()->post('https://apps.firmaperu.gob.pe/admin/api/security/generate-token', [
            'client_id' => 'Mm1S8TJSwTIwNTI3MTQ3NjEyAJeNy7hJMw',
            'client_secret' => 'GWtXjSdO_lbP_vyolY0IZNxYfX1vKSwcNIQ',
        ]);

            return $response;
     }

     public function parametrogral(Request $request)
     {
        header('Access-Control-Allow-Origin', '*');
        // $datos=$request->all();
        // $ruta=url('/firmaperu/parametrofirma');
        $rutadelparametro=route('firmaperu.parametrofirma');
        $posx=$request->posx;
        $posy=$request->posy;
        $motivofirma=$request->motivo;
        $pagina=$request->pagina;
        $cargo=$request->cargo;
        $estilofirma=$request->estilofirma;
        $rutaarchivo=$request->rutaarchivo;
        $ruta=$request->ruta;
        $urlpdf=$request->urlpdf;
        $motivo = [
            0=>"Soy el autor del documento",
            1=>"En señal de conformidad",
            2=>"Doy Visto Bueno",
            3=>"Por encargo",
            4=>"Doy fé"
        ];
        
        $motivofirma=@$motivo[intval($motivofirma["motivo"])];
        
            $noarchivo=time().'.php';// nombre del archivo temporal
            $rutaparametro=$ruta.'/parametrosfirma/'.$noarchivo;
            $paramfirma ='{
                        "signatureFormat": "PAdES",
                        "signatureLevel": "B",
                        "signaturePackaging": "enveloped",
                        "documentToSign":"'.$urlpdf.'",
                        "certificateFilter": ".*",
                        "webTsa": "",
                        "userTsa": "",
                        "passwordTsa": "",
                        "theme": "oscuro",
                        "visiblePosition": true,
                        "contactInfo": "",
                        "signatureReason": "'.$motivofirma.'",
                        "bachtOperation": false,
                        "oneByOne": true,
                        "signatureStyle": '.$estilofirma.',
                        "imageToStamp":"'.$ruta.'/img/firmaperu.png",
                        "stampTextSize": 14,
                        "stampWordWrap": 37,
                        "role": "'.$cargo.'",
                        "stampPage": '.$pagina.',
                        "positionx": '.$posx.',
                        "positiony": '.$posy.',
                        "uploadDocumentSigned":"'.$ruta.'/Uploadx.php?archivo='.$noarchivo.'&url='.$rutaarchivo.'",
                        "certificationSignature": false,
                        "token":"'.$this->generatoken().'"
                }';

                $parametrofirma='<?php echo "'.base64_encode($paramfirma).'"; ?>';//$paramfirma;

                
                Storage::disk('parametrosfirma')->put($noarchivo, $parametrofirma);// guardamos el archivo
                $rutaphp=storage_path('parametrosfirma/'.$noarchivo);

                $rutapublicadephp = public_path("parametrosfirma/").$noarchivo;            
                copy($rutaphp,$rutapublicadephp);
                // Storage::delete('parametrosfirma/'.$noarchivo);
                unlink($rutaphp);//eliminamos del storage luego de copiar
                // $rutaparametro=$ruta.'/parametrosfirma/'.$noarchivo;

        $param=[
            'param_url'=>$rutaparametro,
            'param_token'=>'1626476967',
            'document_extension'=>'pdf'            
            ];

            $jsonReplaces = array(array("\\"),
            array(''));
        $r =  str_replace($jsonReplaces[0], $jsonReplaces[1], json_encode((Object)$param));

        return base64_encode($r);
        // return $rutaphp;
     }

     public function parametrofirma()
     {
       
        // return Session('parametrofirma');

     }

     public function firmadorperu()
     {
        return view('firmador');
     }     
     public function versesion()
     {
        return view('parametrofirma');
     }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        if ($request->hasFile('signed_file'))
        {


            return 'correcto';
        }
        return 'correcto';
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Firmaperu  $firmaperu
     * @return \Illuminate\Http\Response
     */
    public function show(Firmaperu $firmaperu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Firmaperu  $firmaperu
     * @return \Illuminate\Http\Response
     */
    public function edit(Firmaperu $firmaperu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Firmaperu  $firmaperu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Firmaperu $firmaperu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Firmaperu  $firmaperu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Firmaperu $firmaperu)
    {
        //
    }
}

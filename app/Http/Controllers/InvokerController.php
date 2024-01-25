<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Archivos;

class InvokerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth' => 'verified'])->except('mostrararchivo');
    }

    public function postArguments(Request $request)
    {
        header('Access-Control-Allow-Origin', '*');
        //type=$_POST['type'];
        //$documentName=$_POST['documentName'];
        // $rutaDeArchivo=$request->ruta_archivo;
      

        $datarachivo=Archivos::find($request->idFile);
        $rutaDelarchivo=$datarachivo->file_url;
        $arraynombrepdf = explode('/', $rutaDelarchivo);
        $nombrearchivo=$arraynombrepdf[6];//[1]: 55-202-4295-INFORME-118-2022.pdf, [0]:firmados


        $type=$request->type;
        $motivo = [
            0=>"Soy el autor del documento",
            1=>"En señal de conformidad",
            2=>"Doy Visto Bueno",
            3=>"Por encargo",
            4=>"Doy fé"
        ];
        /////////// REPRESENTACION GRAFICA//////////////////
        //0=(sello+descripcion) horizontal | 1=(sello+descripcion) vertical | 2=solo sello | 3=solo descripcion
        //0=(sello+descripcion) horizontal=(0,1,3,4)
        //1=(sello+descripcion) vertical=2
        if($request->motivo==2){
            $grafica='1';
        }else{
            $grafica='0';
        }
        ///////////////////////////////////////////////////

        if(isset($request->iddocumento)&&$request->iddocumento!=null){

            // $documentName   =  $request->idFile;
            // $documentName   .=  '-'.$request->iddocumento.'.pdf';
            $documentName=$nombrearchivo;
        }else
            $documentName = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 40).".PDF" ;

        $param=[
                'app'=>'pdf',
                'fileUploadUrl'=>env('APP_URL').'/upload.php?url='.$rutaDelarchivo,//route('invoker.upload'),
                'reason'=>$motivo[$request->motivo],
                'clientId'=>env('CLIENTID'),
                'clientSecret'=>env('CLIENTSECRET'),
                'dcfilter'=>'.*FIR.*|.*FAU.*',
                'posx'=>$request->posx,
                'posy'=>$request->posy,
                'protocol'=>'T',
                'stampAppearanceId'=>$grafica,//'0' 0=(sello+descripcion) horizontal,
                'isSignatureVisible'=>'true',
                'fileDownloadLogoUrl'=>env('APP_URL').'/img/refirma/iLogo1.png',
                'fileDownloadStampUrl'=>env('APP_URL').'/img/refirma/iFirma1.png',
                'pageNumber'=>'0',
                'maxFileSize'=>'5242880',
                'fontSize'=>'7',
                'timestamp'=>'false',
                'idFile'=>'MyForm',
                ];
        if($type=="L")
        {
            $param['type']='L';
            $param['fileDownloadUrl']='';
            $param['outputFile']=$documentName;
            $param['contentFile']='';

        }	
        if($type=="W")
        {
            $param['type']='W';
            $param['outputFile']=$documentName;
            $param['contentFile']=$request->iddocumento.'.pdf';

            
            // $rutaDeArchivo = url('firmados/1667999152-4295-INFORME-205-2022.pdf');
            // $rutaDeArchivo =url($rutaDelarchivo);            
            $rutaDeArchivo =url('/mostrararchivo/'.$request->idFile);            
	       

            $param['fileDownloadUrl']=$rutaDeArchivo;
            //$param['contentFile']='demo.pdf';

       
        }
        //dd($param);
        $jsonReplaces = array(array("\\"),
            array(''));
        $r =  str_replace($jsonReplaces[0], $jsonReplaces[1], json_encode((Object)$param));

        //return base64_encode($r);
        return base64_encode($r);
    }


    public function upload(Request $request)
    {
       

        if ($request->hasFile('MyForm'))
        {

            //get filename with extension
            $filenametostore = $request->file('MyForm')->getClientOriginalName();
            // $str = explode('-', $filenametostore);
            // $id=$str[0];
            // $str = explode('.',$str[1]);
            // $id_documento = reset($str);
            // $file_select = File::where('id','=',$id)
            //     ->where('id_documento','=',$id_documento)
            //     ->first();
            // $doc = Documento::find($id_documento);
            // $doc->docu_firma_electronica=true;
            // $doc->save();
            //Storage::disk('tramite')->put($file_select->file_url, fopen($request->file('MyForm'), 'r+'));
            //Store $filenametostore in the database
            // Storage::disk('firmados')->put($filenametostore, fopen($request->file('MyForm'), 'r+'));
            Storage::disk()->putFileAs('firmados', $filenametostore, $filenametostore);
            return 'correcto';
        }
        return 'correcto';
    }

    public function getArguments(Request $request)
    {
        if(isset($request->iddocumento)){

        }else
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 40).".PDF" ;
        //return 'xeAXhpIbk0oaLYVf87ZznOumrCKWS54UwdHgNJMq.PDF';
    }

    public function getFile(Request $request)
    {
        $documentName = $request->documentName; 

        $separa=DIRECTORY_SEPARATOR;

        $tmp = dirname(tempnam (null,'')); 

        $archivo = $tmp.$separa."upload".$separa.$file_name.$documentName;

        header('Content-Type: application/pdf');
        header('Content-Disposition:attachment;filename="'.$documentName.'"');
        readfile($archivo);
    }
    
    public function mostrararchivo($idfile)
    {
        $datarachivo=Archivos::find($idfile);
        $rutaDelarchivo=$datarachivo->file_url;

        	$rutaDeArchivo = Storage::path($rutaDelarchivo);
            $headers = array(
                'Content-Type: application/pdf',
            );
            return response()->file($rutaDeArchivo,$headers);

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

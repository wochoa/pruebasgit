<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Response;
use Storage;

class Archivos extends Model
{
    use HasFactory;
    protected $fillable = ['file_url','file_name','file_tipo','file_size','file_mostrar','file_principal','file_html','file_generado','id_documento','id_documento_externo','id_proy_informe','created_at','updated_at']; 
    protected $table='tram_file';
    protected $primaryKey = 'id';

    public static function getPdf($id_file, $id, $tipo)
    {
        $where = [
            ['id', $id_file],
        ];
        if ($tipo == 1) {
            $where[] = ['id_documento', $id];
        } else {
            $where[] = ['id_documento_externo', $id];
        }
        $file_select = Archivos::where($where)->first();
        if($file_select!=null) {
            // $file = Storage::disk('tramite')->get($file_select->file_url);
            // $file = Storage::path($file_select->file_url);
            $file =url($file_select->file_url); 
            
            // return Response::make($file, 200, ['Content-Type' => Storage::path('tramite')->getMimeType($file_select->file_url)]);
            // return Response::make($file, 200);

            $file = Storage::path($file_select->file_url);
            $headers = array(
                'Content-Type: application/pdf',
            );
            return response()->file($file,$headers);

        } else
            abort(404, 'No encontrado.');
    }
}

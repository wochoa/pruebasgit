<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDocumentoCorrel extends Model
{
    use HasFactory;
    protected $table='tram_tipodocumento_correl';
   protected $primaryKey='id';
    
    protected $fillable=[
        'tdco_idtipodocumento',
        'tdco_iddependencia',
        'tdco_idusuario',
        'tdco_periodo',
        'tdco_numero'
    ];
    
    protected $guarded=[];
    public static function addCorrelativo(Documento $doc, $idCorrelativo){
        $corr               = ($idCorrelativo==null)?new TipoDocumentoCorrel():TipoDocumentoCorrel::find($idCorrelativo);

        if($idCorrelativo==null)
        {
            $corr->tdco_periodo         = substr($doc->docu_fecha_doc,0,4);
            $corr->tdco_idtipodocumento = $doc->docu_idtipodocumento;
            $corr->tdco_iddependencia   = $doc->docu_iddependencia;
            $corr->tdco_idusuario       = $doc->docu_tipo==1?$doc->docu_idusuario:null;
        }
        $corr->tdco_numero              = $doc->docu_numero_doc+1;
        $corr->save();
    }
}

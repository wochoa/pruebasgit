<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Depedencia;
use App\Models\Archivos;

class DocumentoExterno extends Model
{
    use HasFactory;

    protected $table = 'tram_documento_externo';
    protected $fillable = [
        "docu_digital",
        "docu_iddependencia",
        'id_dependencia',
        "docu_ruc",
        "docu_detalle",
        "docu_firma",
        "docu_cargo",
        "docu_idtipodocumento",
        "docu_fecha_doc",
        "docu_numero_doc",
        "docu_siglas_doc",
        "docu_folios",
        "docu_asunto",
        "docu_emailorigen",
        "docu_estado",
        "docu_idtdoc",
        "docu_numtdoc",
        "docu_idexma",
        "docu_domic",
        "docu_dni",
        "docu_telef",
        "docu_firma_electronica",
        "codigo",

    ];
    protected $hidden = [
        'updated_at',
        'docu_archivo'
    ];
    protected $with = ['dependencia'];

    public function getIdString()
    {
        return str_pad($this->id, 8, "0", STR_PAD_LEFT);
    }
    public function docuArchivo()
    {
        return $this->hasMany(Archivos::class, 'id_documento_externo', 'id');
    }

    public function dependencia()
    {
        return $this->belongsTo(Depedencia::class, 'id_dependencia', 'iddependencia')->select('iddependencia','depe_nombre');
    }

    public function operacion()
    {
        return $this->hasMany(Operacion::class, 'oper_iddocumento', 'iddocumento')->with('dependenciaDestino')->whereIn('oper_idtope', [2,3])->orderBy('idoperacion','asc');
    }

    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'docu_idtipodocumento', 'idtdoc');
    }
}

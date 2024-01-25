<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tram_documento extends Model
{
    use HasFactory;
    protected $table = 'tram_documento';
    protected $primaryKey = 'iddocumento';

    protected $fillable = [
        'docu_origen',
        'docu_tipo',
        'docu_hora',
        'docu_idprioridad',
        'docu_forma',
        'docu_iddependencia',
        'docu_detalle',
        'docu_firma',
        'docu_cargo',
        'docu_idtipodocumento',
        'docu_fecha_doc',
        'docu_numero_doc',
        'docu_siglas_doc',
        'docu_proyectado',
        'docu_idrecepcion',
        'docu_folios',
        'docu_asunto',
        'docu_relacionado',
        'docu_idusuario',
        'docu_idusuariodependencia',
        'docu_estado',
        'docu_clastupa',
        'docu_diasatencion',
        'docu_idtdoc',
        'docu_idtupa',
        'docu_idexma',
        'docu_dni',
        'docu_contrasenia',
        'docu_firma_electronica',
        'docu_fecharegistro',
        'docu_digital',
        'docu_emailorigen',
        'docu_referencias',
        'docu_telef',
        'docu_domic',
    ];

    protected $casts = [
        'iddocumento'               => 'integer',
        'docu_idprioridad'          => 'integer',
        'docu_iddependencia'        => 'integer',
        'docu_idtipodocumento'      => 'integer',
        'docu_numero_doc'           => 'integer',
        'docu_idrecepcion'          => 'integer',
        'docu_folios'               => 'integer',
        'docu_relacionado'          => 'integer',
        'docu_idusuario'            => 'integer',
        'docu_idusuariodependencia' => 'integer',
        'docu_estado'               => 'integer',
        'docu_diasatencion'         => 'integer',
        'docu_idtupa'               => 'integer',
        'docu_idexma'               => 'integer',
        'docu_origen'               => 'integer',
        'docu_doc_generado'         => 'integer',
        'docu_referencias'          => 'array',
        'docu_digital'              => 'boolean',
    ];
    protected $guarded = [

    ];

    public function docuArchivo()
    {
        return $this->hasMany(Archivos::class, 'id_documento', 'iddocumento');
    }
    public function getIdString()
    {
        return str_pad($this->iddocumento, 8, "0", STR_PAD_LEFT);
    }
    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'docu_idtipodocumento', 'idtdoc');
    }
        public function getExpedienteString()
    {
        return str_pad($this->docu_idexma, 8, "0", STR_PAD_LEFT);
    }
    public function getNumeroDocumentoAttribute()
    {
        return "{$this->tipoDocumento->tdoc_descripcion} {$this->docu_numero_doc}-{$this->docu_siglas_doc}";

    }
}

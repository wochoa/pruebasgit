<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
    use HasFactory;

    protected $table='tram_tipodocumento';
    protected $primaryKey = 'idtdoc';

    protected $casts = [
      'tdoc_mpv' => 'boolean'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public static function getTiposAsArray()
    {
        $td = TipoDocumento::select(['idtdoc','tdoc_descripcion'])->orderBy('tdoc_descripcion', 'asc')->get();
        $return = [];
        foreach ($td as $id=>$value)
        {
            $return[$value->idtdoc]=$value;

        }
        return $return;
    }
}

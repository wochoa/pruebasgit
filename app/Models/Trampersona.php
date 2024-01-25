<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trampersona extends Model
{
    use HasFactory;
    protected $table='tram_persona';
    protected $fillable=[
        'apPrimer',
        'apPrimer',
        'direccion',
        'dni',
        'foto',
        'prenombres',
        'restriccion',
        'ubigeo',
        'telefono',
        'correo'
    ];
    protected $hidden = ['id','created_at','updated_at'];
    protected $guarded=[

    ];
    public function setData($data){
        $this->apPrimer     = $data->apPrimer;
        $this->apSegundo    = $data->apSegundo;
        $this->direccion    = $data->direccion;
        $this->estadoCivil  = $data->estadoCivil;
        $this->foto         = $data->foto;
        $this->prenombres   = $data->prenombres;
       /* $this->restriccion  = $data->restriccion;
        $this->ubigeo       = $data->ubigeo;*/
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archivador extends Model
{
    use HasFactory;
    protected $table='tram_archivador';
    protected $primaryKey='idarch';
     
    //public $timestamps=true;
    protected $fillable=[
        'arch_iddependencia',
        'arch_idusuario',
        'arch_nombre',
        'arch_periodo',
        'arch_idusuarioa'
    ];
     
     protected $guarded=[
         
     ];
 
     public function getForUpdate(){
 
         return json_encode((Object)[
             'idarch'=>$this->idarch,
             'arch_iddependencia'=>$this->arch_iddependencia,
             'arch_idusuario'=>$this->arch_idusuario,
             'arch_nombre'=>$this->arch_nombre,
             'arch_periodo'=>$this->arch_periodo,
             'arch_idusuarioa'=>(bool)$this->arch_idusuarioa
         ]);
     }
}

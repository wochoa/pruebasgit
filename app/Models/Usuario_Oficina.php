<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario_Oficina extends Model
{
    use HasFactory;

    protected $table = 'usuario_oficinas';
    protected $primaryKey = 'iduserof';

    protected $fillable = [
        'iduser',
        'idunidad',
        'userupdate',
        'acceso',
        'cargo',
        'estado',        
    ];
}

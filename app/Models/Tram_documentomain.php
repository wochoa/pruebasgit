<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tram_documentomain extends Model
{
    use HasFactory;
    protected $fillable = ['dmai_idusu','created_at','updated_at']; 
    protected $table='tram_documentomain';
    protected $primaryKey = 'iddocumentomain';
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depedencia extends Model
{
    use HasFactory;
    protected $table = 'tram_dependencia';

    protected $primaryKey = 'iddependencia';
}

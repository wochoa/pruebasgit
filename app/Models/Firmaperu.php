<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Firmaperu extends Model
{
    use HasFactory;
    protected $fillable = ['id','token','created_at',
    'updated_at'];

    protected $table = 'firmaperu';
}

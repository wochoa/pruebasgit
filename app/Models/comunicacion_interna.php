<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Storage;
use Response;   

class comunicacion_interna extends Model
{
    use HasFactory;

    protected $table='comunicacion_interna';

    protected $primaryKey='id';

    public function getIdString()
    {
        return str_pad($this->id, 5, "0", STR_PAD_LEFT);
    }

    public function getForComunicacionInterna()
    {
        return json_encode((Object)[
            'id'=>$this->id,
            'id_solicitante'=>$this->id_solicitante,
            'sustento'=>$this->sustento,
            'imagen'=>$this->imagen,
            'fecha_inicio'=>$this->fecha_inicio,
            'fecha_fin'=>$this->fecha_fin,
            'estado'=>$this->estado,
            'url'=>$this->url
        ]);
    }

    public function getImagen(){
        $vidaEnMinutos = 15;
        $url = Storage::disk('imagenes')->get($this->imagen);
        $response = Response::make($url,200,['Content-Type' => Storage::disk('imagenes')->getMimeType($this->imagen), 'Cache-Control' => 'max-age='.($vidaEnMinutos*60).', public']);

        $response->setLastModified(new \DateTime('now'));
        $response->setExpires(\Carbon\Carbon::now()->addMinutes($vidaEnMinutos));
        return $response;

    }
}

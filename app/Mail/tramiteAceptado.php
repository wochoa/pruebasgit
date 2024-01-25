<?php
namespace App\Mail;

use App\Models\Depedencia;
use App\Models\Tram_documento;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\DocumentoExterno;

class tramiteAceptado extends Mailable
{
    use Queueable, SerializesModels;
    public $doc;
    public $user;
    public $dependencia;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Tram_documento $doc)
    {
        $this->subject='Solicitud de trámite registrado';
        $this->doc       = $doc;
        $iddepe = DocumentoExterno::where('iddocumento',$this->doc->iddocumento)->value('id_dependencia');
        // $this->user->load('Depedencia');
        $this->dependencia = Depedencia::find($iddepe);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.MesaElectronica.tramiteAceptado');
    }
}

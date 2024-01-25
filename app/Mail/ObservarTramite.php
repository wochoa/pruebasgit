<?php

namespace App\Mail;
use App\Models\Depedencia;
use App\Models\DocumentoExterno;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ObservarTramite extends Mailable
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
    public function __construct(DocumentoExterno $doc)
    {
        $this->subject='Solicitud de trámite observado';
        $this->doc       = $doc;
        // $this->user = \App\User::find($this->doc->updated_by);
        // $this->user->load('dependencia');
        // $this->dependencia = Dependencia::find($this->user->dependencia->depe_depende);
        $iddepe = DocumentoExterno::where('id',$this->doc->id)->value('id_dependencia');
        $this->dependencia = Depedencia::find($iddepe);
   
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.MesaElectronica.observarTramite');
    }
}

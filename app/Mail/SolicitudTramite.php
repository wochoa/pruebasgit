<?php

namespace App\Mail;

use App\Models\DocumentoExterno;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SolicitudTramite extends Mailable
{
    use Queueable, SerializesModels;
    public $doc;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(DocumentoExterno $doc)
    {
        $this->subject='Solicitud de trámite recibida';
        $this->doc = $doc;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->view('mail.name');
        return $this->view('mail.MesaElectronica.solicitudTramite');
    }
}


<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FaleConosco extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $assunto;
    protected $mensagem;

    public function __construct($assunto,$mensagem)
    {
        $this->assunto = $assunto;
        $this->mensagem = $mensagem;
 
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.contacto')->with(["assunto"=>$this->assunto,"mensagem"=>$this->mensagem]);
    }
}

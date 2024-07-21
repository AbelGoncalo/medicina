<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;

class MedicoNotificacao extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $utente;
    protected $data_realizacao;
    protected $consulta;
    public function __construct($utente,$data_realizacao,$consulta)
    {
        $this->data_realizacao = $data_realizacao;
        $this->utente = $utente;
        $this->consulta = $consulta;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        $utente = (String) $this->utente;
        $consulta = (String) $this->consulta;

        $dia_realizacao = Carbon::parse($this->data_realizacao)->format('d');
        $mes_realizacao = Carbon::parse($this->data_realizacao)->format('m');
       $hora =  Carbon::parse($this->data_realizacao)->format('H:i');
        return [
            "mensagen"=>"A consulta de ".$consulta." que o utente "
            .$utente." marcou com o Senhor, deve ser realizada no dia "
            .$dia_realizacao." de ".$mes_realizacao." as ".$hora." . Obrigado!"
        ];
    }
}

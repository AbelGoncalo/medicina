<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Carbon;
use Carbon\Carbon as CarbonCarbon;

class CancelarConsulta extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $exame;
    protected $data_marcacao;
    public function __construct($exame,$data_marcacao)
    {
        $this->exame = $exame;
        $this->data_marcacao = $data_marcacao;
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
    public function toArray($notifiable)
    {
        $dia =  \Carbon\Carbon::parse($this->data_marcacao)->format('d');
        $mes =  \Carbon\Carbon::parse($this->data_marcacao)->format('m');

        return [
           
            'mensagen'=>'A sua consulta de '.$this->exame.', marcada no dia'.$dia.' de '.$mes.'  foi reprovada.',

        ];
    }
}

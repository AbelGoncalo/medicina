<?php

namespace App\Notifications;

use App\Models\Consulta;
use DateTime;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;

class DataRealizacao extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    // protected $data_marcacao;
    protected $data_realizacao;
    protected $data_marcacao;
    public function __construct($data_marcacao,$data_realizacao)
    {
         $this->data_marcacao = $data_marcacao;
         $this->data_realizacao = $data_realizacao;
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
    // public function toArray($notifiable)
    // {
     
    //     // $consulta = Consulta::all();
    //     // return [
          
             
            
    //     // ];
    // }


     public function toDatabase($notifiable)
     {
         

        // Dia e mes que a consulta foi marcada
        $dia_marcacao = Carbon::parse($this->data_marcacao)->format('d');
        $mes_marcacao = Carbon::parse($this->data_marcacao)->format('m');


        // Dia e mes que a consulta sera realizada
        $dia_realizacao = Carbon::parse($this->data_realizacao)->format('d');
        $mes_realizacao = Carbon::parse($this->data_realizacao)->format('m');
        $hora = Carbon::parse($this->data_realizacao)->format('H:i');
        
         
    
 
      
       return [
          
             'mensagen' =>"A  consulta marcada no dia ".$dia_marcacao." de ".$mes_marcacao.
             ", deverá ser realizada no dia ".$dia_realizacao." de ".$mes_realizacao." as ".$hora." . Pedimos que compareça na Clinica, obrigado!", 
            
         ];
       
     }
}

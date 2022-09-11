<?php

namespace App\Notifications;

use App\Models\RegisterToken as Token;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class RegisterToken extends Notification
{
    use Queueable,Notifiable;

    protected Token $token;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $correo ="")
    {
        if(empty($correo)){
            throw new Exception("intento de  registro sin correo");
        }

        $user = User::where("email",$correo)->first();
        if(!$user)
            throw new Exception("no existe el usuario con correo:".$correo);

        $token  = Token::where("id_user",$user->id)->first();
        if(!$token){
           $token= Token::create(["id_user"=>$user->id]);
        }else if($token->due_date<now()){
            Token::where("id_user", $user->id)->delete();
            $token= Token::create(["id_user"=>$user->id]);
        }

        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
                    ->greeting('Token para Registro')
                    ->line('Este es el Token para validar su registro a VRA KMS')
                    ->line($this->token->code)
                    ->line('Durara Activo:'.Env("REGISTER_TOKEN_DUE_TIME",10)." minutos");
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}

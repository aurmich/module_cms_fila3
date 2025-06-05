<?php

namespace Modules\Notify\Channels;

use Illuminate\Notifications\Notification;
use Modules\Notify\Actions\SMS\SendNetfunSMSAction;
use Modules\Notify\DTOs\NetfunSMSMessage;

class NetfunChannel
{
    protected SendNetfunSMSAction $sendSMSAction;
    
    public function __construct(SendNetfunSMSAction $sendSMSAction)
    {
        $this->sendSMSAction = $sendSMSAction;
    }
    
    /**
     * Invia la notifica tramite Netfun SMS
     * 
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     * @return array|null
     */
    public function send($notifiable, Notification $notification)
    {
        // Ottieni il numero di telefono dal Notifiable
        if (!$to = $notifiable->routeNotificationForNetfun($notification)) {
            return null;
        }
        
        // Ottieni il messaggio dalla notifica
        $message = $notification->toNetfun($notifiable);
        
        if (!$message instanceof NetfunSMSMessage) {
            throw new \Exception('Il metodo toNetfun() deve restituire un\'istanza di NetfunSMSMessage');
        }
        
        // Esegui l'invio tramite la Queueable Action
        // L'esecuzione avverrà in modo asincrono (in background)
        return $this->sendSMSAction
            ->onQueue('sms') // Esegui sulla coda 'sms'
            ->execute(
                $to,
                $message->content,
                $message->toArray()
            );
    }
}

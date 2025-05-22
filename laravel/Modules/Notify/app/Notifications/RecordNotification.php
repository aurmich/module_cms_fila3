<?php

namespace Modules\Notify\Notifications;

use Modules\Notify\Datas\SmsData;
use Modules\Notify\Emails\SpatieEmail;
use Illuminate\Database\Eloquent\Model;
use Modules\Notify\Channels\SmsChannel;
use Illuminate\Notifications\Notification;

class RecordNotification extends Notification
{
    protected Model $record;
    protected string $slug;

    public function __construct(Model $record, string $slug)
    {
        $this->record = $record;
        $this->slug = $slug;
    }

    public function via($notifiable): array
    {
        //return ['mail'];
        return [SmsChannel::class];
    }

    public function toMail($notifiable): SpatieEmail
    {

        $email = new SpatieEmail($this->record, $this->slug);

        // Importante: garantisci che ci sia sempre un destinatario
        if (method_exists($notifiable, 'routeNotificationFor')) {
            // Ottieni l'email dal notifiable
            $email->to($notifiable->routeNotificationFor('mail'));
        }

        return $email;
    }

    /**
     * Get the SMS representation of the notification.
     *
     * @param object $notifiable
     * @return SmsData
     */
    public function toSms(object $notifiable): SmsData
    {
        $email = new SpatieEmail($this->record, $this->slug);
        /*
        dddx([
            'methods' => get_class_methods($email),
           // 'text' => $email->text(),
           'getHtmlLayout' => $email->getHtmlLayout(),


        ]);
        */
        // If the notifiable entity has a routeNotificationForSms method,
        // we'll use that to get the destination phone number
        //dddx($notifiable);//Illuminate\Notifications\AnonymousNotifiable

        if (method_exists($notifiable, 'routeNotificationFor')) {
            $to = $notifiable->routeNotificationFor('sms');
        }

        $smsData = SmsData::from(['from'=>'Xot','to'=>$to,'body'=>'test']);


        return $smsData;
    }
}
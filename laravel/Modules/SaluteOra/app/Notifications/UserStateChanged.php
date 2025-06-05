<?php

namespace Modules\SaluteOra\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserStateChanged extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;
    protected $newState;

    /**
     * Create a new notification instance.
     *
     * @param mixed $user
     * @param string $newState
     * @return void
     */
    public function __construct($user, string $newState)
    {
        $this->user = $user;
        $this->newState = $newState;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Your account status has changed')
                    ->line('Dear ' . $this->user->name . ',')
                    ->line('Your account status has been updated to: ' . $this->newState)
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'user_id' => $this->user->id,
            'new_state' => $this->newState,
        ];
    }
}

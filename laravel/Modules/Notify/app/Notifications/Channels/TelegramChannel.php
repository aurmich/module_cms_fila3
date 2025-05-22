<?php

namespace Modules\Notify\Notifications\Channels;

use Illuminate\Notifications\Notification;
use Modules\Notify\Actions\Telegram\BotTelegramAction;
use Modules\Notify\Datas\TelegramMessageData;

class TelegramChannel
{
    /**
     * Invia la notifica tramite Telegram.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        if (!method_exists($notification, 'toTelegram')) {
            throw new \Exception('Il metodo toTelegram() non è definito nella notifica.');
        }

        if (!method_exists($notifiable, 'routeNotificationForTelegram')) {
            throw new \Exception('Il metodo routeNotificationForTelegram() non è definito nel notifiable.');
        }

        $message = $notification->toTelegram($notifiable);
        $chatId = $notifiable->routeNotificationForTelegram();

        if (empty($chatId)) {
            throw new \Exception('Chat ID Telegram non trovato per il notifiable.');
        }

        $action = new BotTelegramAction();
        $result = $action->execute(new TelegramMessageData(
            chat_id: $chatId,
            text: $message
        ));

        if (!$result['success']) {
            throw new \Exception('Errore nell\'invio del messaggio Telegram: ' . ($result['error'] ?? 'Errore sconosciuto'));
        }
    }
}

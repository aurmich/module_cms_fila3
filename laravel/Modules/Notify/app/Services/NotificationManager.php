<?php

declare(strict_types=1);

namespace Modules\Notify\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Modules\Notify\Actions\SendNotificationAction;
use Modules\Notify\Models\NotificationLog;
use Modules\Notify\Models\NotificationTemplate;

class NotificationManager
{
    /**
     * Invia una notifica utilizzando un template.
     *
     * @param Model $recipient Il destinatario della notifica
     * @param string $templateCode Il codice del template da utilizzare
     * @param array $data I dati per compilare il template
     * @param array $channels I canali da utilizzare (opzionale)
     * @param array $options Opzioni aggiuntive per l'invio
     * 
     * @return NotificationLog
     */
    public function send(
        Model $recipient,
        string $templateCode,
        array $data = [],
        array $channels = [],
        array $options = []
    ): NotificationLog {
        return app(SendNotificationAction::class)->execute(
            $recipient,
            $templateCode,
            $data,
            $channels,
            $options
        );
    }

    /**
     * Invia una notifica a più destinatari.
     *
     * @param array $recipients Array di destinatari
     * @param string $templateCode Il codice del template da utilizzare
     * @param array $data I dati per compilare il template
     * @param array $channels I canali da utilizzare (opzionale)
     * @param array $options Opzioni aggiuntive per l'invio
     * 
     * @return array<NotificationLog>
     */
    public function sendMultiple(
        array $recipients,
        string $templateCode,
        array $data = [],
        array $channels = [],
        array $options = []
    ): array {
        $logs = [];

        foreach ($recipients as $recipient) {
            $logs[] = $this->send($recipient, $templateCode, $data, $channels, $options);
        }

        return $logs;
    }

    /**
     * Recupera un template per codice.
     *
     * @param string $code Il codice del template
     * @return NotificationTemplate|null
     */
    public function getTemplate(string $code): ?NotificationTemplate
    {
        return NotificationTemplate::where('code', $code)
            ->where('is_active', true)
            ->first();
    }

    /**
     * Recupera i template per categoria.
     *
     * @param string $category La categoria dei template
     * @return \Illuminate\Database\Eloquent\Collection<NotificationTemplate>
     */
    public function getTemplatesByCategory(string $category)
    {
        return NotificationTemplate::where('category', $category)
            ->where('is_active', true)
            ->get();
    }

    /**
     * Recupera i template per canale.
     *
     * @param string $channel Il canale di notifica
     * @return \Illuminate\Database\Eloquent\Collection<NotificationTemplate>
     */
    public function getTemplatesByChannel(string $channel)
    {
        return NotificationTemplate::forChannel($channel)
            ->where('is_active', true)
            ->get();
    }

    /**
     * Recupera le statistiche di invio per un template.
     *
     * @param NotificationTemplate $template Il template
     * @return array<string, mixed>
     */
    public function getTemplateStats(NotificationTemplate $template): array
    {
        $logs = $template->logs();

        return [
            'total' => $logs->count(),
            'sent' => $logs->where('status', NotificationLog::STATUS_SENT)->count(),
            'delivered' => $logs->where('status', NotificationLog::STATUS_DELIVERED)->count(),
            'failed' => $logs->where('status', NotificationLog::STATUS_FAILED)->count(),
            'opened' => $logs->where('status', NotificationLog::STATUS_OPENED)->count(),
            'clicked' => $logs->where('status', NotificationLog::STATUS_CLICKED)->count(),
        ];
    }

    /**
     * Recupera le statistiche di invio per un destinatario.
     *
     * @param Model $recipient Il destinatario
     * @return array<string, mixed>
     */
    public function getRecipientStats(Model $recipient): array
    {
        $logs = NotificationLog::forNotifiable($recipient)->get();

        return [
            'total' => $logs->count(),
            'sent' => $logs->where('status', NotificationLog::STATUS_SENT)->count(),
            'delivered' => $logs->where('status', NotificationLog::STATUS_DELIVERED)->count(),
            'failed' => $logs->where('status', NotificationLog::STATUS_FAILED)->count(),
            'opened' => $logs->where('status', NotificationLog::STATUS_OPENED)->count(),
            'clicked' => $logs->where('status', NotificationLog::STATUS_CLICKED)->count(),
        ];
    }
} 
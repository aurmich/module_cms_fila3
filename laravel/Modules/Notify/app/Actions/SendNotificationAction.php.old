<?php

declare(strict_types=1);

namespace Modules\Notify\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Modules\Notify\Models\NotificationLog;
use Modules\Notify\Models\NotificationTemplate;
use Modules\Notify\Notifications\GenericNotification;
use Spatie\QueueableAction\QueueableAction;

/**
 * Action per l'invio di notifiche multi-canale.
 * Supporta l'invio via email, SMS e notifiche in-app.
 */
class SendNotificationAction
{
    use QueueableAction;

    /**
     * Invia una notifica utilizzando un template.
     *
     * @param Model $recipient Il destinatario della notifica
     * @param string $templateCode Il codice del template da utilizzare
     * @param array $data I dati per compilare il template
     * @param array $channels I canali da utilizzare (opzionale, usa quelli del template se non specificati)
     * @param array $options Opzioni aggiuntive per l'invio
     * 
     * @return NotificationLog
     * @throws \Exception Se il template non esiste o non è attivo
     */
    public function execute(
        Model $recipient,
        string $templateCode,
        array $data = [],
        array $channels = [],
        array $options = []
    ): NotificationLog {
        // Recupera il template
        $template = NotificationTemplate::where('code', $templateCode)
            ->where('is_active', true)
            ->first();

        if (!$template) {
            throw new \Exception("Template {$templateCode} non trovato o non attivo");
        }

        // Verifica condizioni di invio
        if (!$template->shouldSend($data)) {
            return $this->createSkippedNotification($recipient, $template, $data);
        }

        // Compila il template
        $compiled = $template->compile($data);

        // Determina i canali da utilizzare
        $effectiveChannels = $channels ?: $template->channels;

        // Crea il log della notifica
        $log = NotificationLog::create([
            'template_id' => $template->id,
            'notifiable_type' => get_class($recipient),
            'notifiable_id' => $recipient->getKey(),
            'status' => NotificationLog::STATUS_PROCESSING,
            'data' => $data,
            'tenant_id' => $template->tenant_id,
        ]);

        // Processa ogni canale
        foreach ($effectiveChannels as $channel) {
            try {
                $this->sendViaChannel($recipient, $channel, $compiled, $options, $log);
            } catch (\Exception $e) {
                $log->markAsFailed($e->getMessage());
                continue;
            }
        }

        return $log;
    }

    /**
     * Invia la notifica attraverso un canale specifico.
     *
     * @param Model $recipient
     * @param string $channel
     * @param array $compiled
     * @param array $options
     * @param NotificationLog $log
     * @return void
     */
    protected function sendViaChannel(
        Model $recipient,
        string $channel,
        array $compiled,
        array $options,
        NotificationLog $log
    ): void {
        $log->update(['channel' => $channel]);

        switch ($channel) {
            case 'mail':
                $this->sendMail($recipient, $compiled, $options, $log);
                break;
            case 'database':
                $this->sendDatabase($recipient, $compiled, $options, $log);
                break;
            case 'sms':
                $this->sendSms($recipient, $compiled, $options, $log);
                break;
            default:
                throw new \Exception("Canale {$channel} non supportato");
        }
    }

    /**
     * Invia una notifica via email.
     */
    protected function sendMail(Model $recipient, array $compiled, array $options, NotificationLog $log): void
    {
        if (!method_exists($recipient, 'routeNotificationForMail')) {
            throw new \Exception('Il destinatario non supporta le notifiche email');
        }

        $email = $recipient->routeNotificationForMail();
        if (!$email) {
            throw new \Exception('Email destinatario non disponibile');
        }

        Mail::to($email)->send(new GenericNotification(
            $compiled['subject'],
            $compiled['body_html'] ?? $compiled['body_text'],
            ['mail'],
            array_merge($options, [
                'text_view' => $compiled['body_text'],
                'tracking_pixel_url' => route('notify.track.open', ['id' => $log->id]),
            ])
        ));

        $log->markAsSent();
    }

    /**
     * Invia una notifica nel database.
     */
    protected function sendDatabase(Model $recipient, array $compiled, array $options, NotificationLog $log): void
    {
        Notification::send($recipient, new GenericNotification(
            $compiled['subject'],
            $compiled['body_text'] ?? strip_tags($compiled['body_html']),
            ['database'],
            $options
        ));

        $log->markAsSent();
    }

    /**
     * Invia una notifica via SMS.
     */
    protected function sendSms(Model $recipient, array $compiled, array $options, NotificationLog $log): void
    {
        if (!method_exists($recipient, 'routeNotificationForSms')) {
            throw new \Exception('Il destinatario non supporta le notifiche SMS');
        }

        $phone = $recipient->routeNotificationForSms();
        if (!$phone) {
            throw new \Exception('Numero di telefono destinatario non disponibile');
        }

        // Usa il testo plain o una versione senza HTML
        $message = $compiled['body_text'] ?? strip_tags($compiled['body_html']);

        // Limita la lunghezza del messaggio SMS
        if (mb_strlen($message) > 320) {
            $message = mb_substr($message, 0, 317) . '...';
        }

        Notification::send($recipient, new GenericNotification(
            $compiled['subject'],
            $message,
            ['sms'],
            $options
        ));

        $log->markAsSent();
    }

    /**
     * Crea un log per una notifica saltata a causa delle condizioni.
     */
    protected function createSkippedNotification(
        Model $recipient,
        NotificationTemplate $template,
        array $data
    ): NotificationLog {
        return NotificationLog::create([
            'template_id' => $template->id,
            'notifiable_type' => get_class($recipient),
            'notifiable_id' => $recipient->getKey(),
            'status' => NotificationLog::STATUS_FAILED,
            'status_message' => 'Saltata per condizioni non soddisfatte',
            'data' => $data,
            'tenant_id' => $template->tenant_id,
        ]);
    }
}

<?php

declare(strict_types=1);

namespace Modules\Notify\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Modules\Notify\Datas\SmsData;
use Modules\Notify\Notifications\Channels\SmsChannel;

/**
 * Class SmsNotification
 *
 * Notification class for sending SMS messages through various providers.
 * 
 * @package Modules\Notify\Notifications
 */
class SmsNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The SMS data.
     *
     * @var SmsData
     */
    protected SmsData $smsData;

    /**
     * Additional configuration options.
     *
     * @var array<string, mixed>
     */
    protected array $config;

    /**
     * Create a new notification instance.
     *
     * @param string|SmsData $content The content of the SMS or SmsData object
     * @param array<string, mixed> $config Configuration options including provider
     */
    public function __construct(string|SmsData $content, array $config = [])
    {
        if ($content instanceof SmsData) {
            $this->smsData = $content;
        } else {
            $this->smsData = new SmsData();
            $this->smsData->body = $content;
            
            if (isset($config['to'])) {
                $this->smsData->to = $config['to'];
            }
            
            if (isset($config['from'])) {
                $this->smsData->from = $config['from'];
            }
        }
        
        $this->config = $config;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array<int, string>
     */
    public function via(mixed $notifiable): array
    {
        return [SmsChannel::class];
    }

    /**
     * Get the SMS representation of the notification.
     *
     * @param mixed $notifiable
     * @return SmsData
     */
    public function toSms(mixed $notifiable): SmsData
    {
        // If the notifiable entity has a routeNotificationForSms method,
        // we'll use that to get the destination phone number
        if (method_exists($notifiable, 'routeNotificationForSms')) {
            $this->smsData->to = $notifiable->routeNotificationForSms($this);
        }

        return $this->smsData;
    }

    /**
     * Get the provider configuration for this notification.
     *
     * @return array<string, mixed>
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * Get the provider to use for sending the SMS.
     *
     * @return string|null
     */
    public function getProvider(): ?string
    {
        return $this->config['provider'] ?? null;
    }
}

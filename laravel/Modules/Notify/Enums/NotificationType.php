<?php

declare(strict_types=1);

namespace Modules\Notify\Enums;

enum NotificationType: string
{
    case Email = 'email';
    case Sms = 'sms';
    case Push = 'push';
    
    public static function asSelectArray(): array
    {
        return [
            self::Email->value => __('notify::enums.notification_type.email'),
            self::Sms->value => __('notify::enums.notification_type.sms'),
            self::Push->value => __('notify::enums.notification_type.push'),
        ];
    }
    
    public function color(): string
    {
        return match($this) {
            self::Email => 'success',
            self::Sms => 'warning',
            self::Push => 'info',
        };
    }
    
    public function icon(): string
    {
        return match($this) {
            self::Email => 'heroicon-o-envelope',
            self::Sms => 'heroicon-o-chat-bubble-left-ellipsis',
            self::Push => 'heroicon-o-bell',
        };
    }
}

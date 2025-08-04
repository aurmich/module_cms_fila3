<?php

declare(strict_types=1);

namespace Modules\User\Models\Models;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

abstract class BaseUser extends Authenticatable
{
    use Notifiable;

    /**
     * Get the entity's notifications.
     *
     * @return MorphMany<\Illuminate\Notifications\DatabaseNotification, $this>
     */
    public function notifications(): MorphMany
    {
        /** @var class-string<\Illuminate\Notifications\DatabaseNotification> $notificationClass */
        $notificationClass = config('notifications.notification_model', \Illuminate\Notifications\DatabaseNotification::class);
        
        return $this->morphMany($notificationClass, 'notifiable');
    }
}

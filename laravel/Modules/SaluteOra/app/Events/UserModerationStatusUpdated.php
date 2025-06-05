<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\SaluteOra\Models\User;

class UserModerationStatusUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public User $user;

    /**
     * Create a new event instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}

<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Listeners;

use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;
use Modules\SaluteOra\Models\User;
use Modules\SaluteOra\Notifications\ModerationStatusUpdated;

class UserModerationListener
{
    /**
     * Handle the event when a user's moderation status is updated.
     *
     * @param object $event
     * @return void
     */
    public function handle($event): void
    {
        if (isset($event->user) && $event->user instanceof User) {
            $user = $event->user;
            // Send notification to the user about the status update
            try {
                Notification::send($user, new ModerationStatusUpdated($user));
            } catch (\Exception $e) {
                // Log the error or handle it as needed
                Log::error('Failed to send moderation status notification: ' . $e->getMessage());
            }
        }
    }
}

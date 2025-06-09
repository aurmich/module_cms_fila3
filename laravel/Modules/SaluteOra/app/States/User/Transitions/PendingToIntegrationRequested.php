<?php

namespace Modules\SaluteOra\States\User\Transitions;

use Modules\SaluteOra\Models\User;
use Spatie\ModelStates\Transition;
use Modules\SaluteOra\States\User\Pending;
use Illuminate\Support\Facades\Notification;
use Modules\Notify\Notifications\RecordNotification;
use Modules\SaluteOra\States\User\IntegrationRequested;

class PendingToIntegrationRequested extends Transition
{
    private User $user;
    private ?string $message;

    public function __construct(User $user,?string $message='')
    {
        $this->user = $user;
        $this->message = $message;
    }

    public function handle(): User
    {
        $notify = new RecordNotification(
            $this->user,
            $this->user->type->value . '_integration_requested'
        );

        $notify = $notify->mergeData(['message' => $this->message]);
        Notification::route('mail', $this->user->email)
            //->locale('it')
            ->notify($notify);
dddx('a');
        $this->user->state = new IntegrationRequested($this->user);
        $this->user->save();

        return $this->user;
    }
}

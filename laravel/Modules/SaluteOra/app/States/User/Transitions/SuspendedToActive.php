<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\User\Transitions;

use Illuminate\Support\Str;
use Modules\SaluteOra\Models\User;
use Spatie\ModelStates\Transition;
use Modules\SaluteOra\States\User\Active;
use Modules\SaluteOra\States\User\Suspended;

class SuspendedToActive extends BaseTransition
{
    //---

    public function getNotificationData(): array{
        $user=$this->record;
        $password=Str::random(10);
        $user->update(['password'=>$password]);
        return [
            'message' => $this->message,
            'password' => $password,
        ];
    }
}

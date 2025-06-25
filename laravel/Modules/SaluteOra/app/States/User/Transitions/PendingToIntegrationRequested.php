<?php

namespace Modules\SaluteOra\States\User\Transitions;

use Illuminate\Support\Str;
use Modules\SaluteOra\Models\User;
use Spatie\ModelStates\Transition;
use Modules\SaluteOra\States\User\Pending;
use Illuminate\Support\Facades\Notification;
use Modules\Notify\Notifications\RecordNotification;
use Modules\SaluteOra\States\User\IntegrationRequested;

class PendingToIntegrationRequested extends BaseTransition
{
    

    public function getNotificationData(): array{
        if($this->user->remember_token==null){
            $this->user->remember_token = Str::random(40);
            $this->user->save();
        }

        $register_url = route('register.type',[
            'type'=>$this->user->type->value,
            'email'=>$this->user->email,
            'token'=>$this->user->remember_token,
        ]);

        $data = [
            'message' => $this->message,
            'register_url' => $register_url,
        ];
        return $data;
    }


}

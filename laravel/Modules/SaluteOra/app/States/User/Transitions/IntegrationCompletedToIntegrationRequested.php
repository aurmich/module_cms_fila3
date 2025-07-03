<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\User\Transitions;

use Illuminate\Support\Str;

/**
 * Transizione da IntegrationCompleted a IntegrationRequested.
 * 
 * Questa transizione avviene quando durante la verifica si scopre che servono
 * ulteriori documenti, correzioni o chiarimenti da parte dell'utente.
 */
class IntegrationCompletedToIntegrationRequested extends BaseTransition
{
    //---
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
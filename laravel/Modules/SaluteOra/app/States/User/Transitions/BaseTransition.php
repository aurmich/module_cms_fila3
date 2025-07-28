<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\User\Transitions;

use Illuminate\Support\Str;
use Modules\SaluteOra\Models\User;
use Spatie\ModelStates\Transition;
use Modules\SaluteOra\States\User\Active;
use Modules\SaluteOra\States\User\Inactive;
use Modules\Notify\Notifications\RecordNotification;
use Modules\Xot\States\Transitions\XotBaseTransition;
use Modules\Xot\Contracts\UserContract;

abstract class BaseTransition extends XotBaseTransition
{
    
    

    public function getNotificationSlug(UserContract $recipient): string
    {
        $slug=$this->record->type->value . '-'.Str::of(class_basename(static::class))->kebab()->toString();
        $slug=\Illuminate\Support\Str::slug($slug);
        
        return $slug;
    }

    public function getNotificationData(): array{
        return [
            'message' => $this->message,
            
        ];
    }
}

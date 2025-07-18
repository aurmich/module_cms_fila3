<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\User\Transitions;

use Illuminate\Support\Str;
use Modules\SaluteOra\Models\User;
use Spatie\ModelStates\Transition;
use Modules\SaluteOra\States\User\Active;
use Modules\SaluteOra\States\User\Inactive;
use Modules\Notify\Notifications\RecordNotification;

abstract class BaseTransition extends Transition
{
    
    public function __construct(public User $user, public ?string $message='') {}
     
    public function handle(): User
    {
        $this->sendNotification();
        $class=static::class;
        $newStateClass=Str::of($class)->afterLast('To')->prepend('Modules\SaluteOra\States\User\\')->toString();
        /** @phpstan-ignore assign.propertyType */
        $this->user->state = new $newStateClass($this->user);
        $this->user->save();
        return $this->user;
    }
        
    public function sendNotification(): void{
        $slug=$this->user->type->value . '-'.Str::of(class_basename(static::class))->kebab()->toString();
        $slug=\Illuminate\Support\Str::slug($slug);
        
        $notify = new RecordNotification(
            $this->user,
            $slug
        );

        $data = $this->getNotificationData();
        $notify = $notify->mergeData($data);
        
        \Illuminate\Support\Facades\Notification::route('mail', $this->user->email)
            //->locale('it')
            ->notify($notify);
    }

    public function getNotificationData(): array{
        return [
            'message' => $this->message,
            
        ];
    }
}

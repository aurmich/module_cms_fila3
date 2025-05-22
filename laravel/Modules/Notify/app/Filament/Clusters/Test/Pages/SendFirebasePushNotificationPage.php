<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Clusters\Test\Pages;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Log;
use Filament\Forms\ComponentContainer;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Database\Eloquent\Model;
use Modules\Notify\Filament\Clusters\Test;
use Modules\Xot\Filament\Pages\XotBasePage;
use Illuminate\Support\Facades\Notification;
use Illuminate\Contracts\Auth\Authenticatable;
use Filament\Forms\Concerns\InteractsWithForms;
use Modules\Notify\Datas\FirebaseNotificationData;
use Modules\Notify\Notifications\PushNotification;
use Modules\Xot\Filament\Traits\NavigationLabelTrait;
use Filament\Notifications\Notification as FilamentNotification;

/**
 * @property ComponentContainer $pushForm
 */
class SendFirebasePushNotificationPage extends XotBasePage
{
    
    public ?array $pushData = [];
    
    protected static ?string $navigationIcon = 'heroicon-o-bell-alert';
    
    protected static string $view = 'notify::filament.pages.send-push';
    
    protected static ?string $cluster = Test::class;
    
    public function mount(): void
    {
        $this->fillForms();
    }

    protected function getForms(): array
    {
        return [
            'pushForm',
        ];
    }

    protected function fillForms(): void
    {
        $this->pushForm->fill();
    }

    public function pushForm(Form $form): Form
    {
        return $form
            ->schema($this->getPushFormSchema())
            ->model($this->getUser())
            ->statePath('pushData');
    }

    public function getPushFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('token')
                ->label(__('notify::push.form.token.label'))
                ->required()
                ->helperText(__('notify::push.form.token.helper')),
            Forms\Components\TextInput::make('title')
                ->label(__('notify::push.form.title.label'))
                ->required()
                ->maxLength(100),
            Forms\Components\Textarea::make('body')
                ->label(__('notify::push.form.body.label'))
                ->required()
                ->rows(3),
            Forms\Components\TextInput::make('image_url')
                ->label(__('notify::push.form.image_url.label'))
                ->url()
                ->helperText(__('notify::push.form.image_url.helper')),
            Forms\Components\Select::make('notification_type')
                ->label(__('notify::push.form.notification_type.label'))
                ->options([
                    'message' => 'Message',
                    'alert' => 'Alert',
                    'reminder' => 'Reminder',
                    'update' => 'Update',
                ])
                ->default('message')
                ->required(),
            Forms\Components\Toggle::make('high_priority')
                ->label(__('notify::push.form.high_priority.label'))
                ->default(false)
                ->helperText(__('notify::push.form.high_priority.helper')),
            Forms\Components\KeyValue::make('custom_data')
                ->label(__('notify::push.form.custom_data.label'))
                ->keyLabel(__('notify::push.form.custom_data.key_label'))
                ->valueLabel(__('notify::push.form.custom_data.value_label'))
                ->helperText(__('notify::push.form.custom_data.helper')),
        ];
    }

    public function sendPushNotification(): void
    {
        $data = $this->pushForm->getState();
        
        try {
            // Creare i dati della notifica Firebase
            $notificationData = new FirebaseNotificationData(
                token: $data['token'],
                title: $data['title'],
                body: $data['body'],
                imageUrl: $data['image_url'] ?? null,
                notificationType: $data['notification_type'],
                highPriority: $data['high_priority'] ?? false,
                customData: $data['custom_data'] ?? []
            );
            
            // Inviare la notifica push
            Notification::route('firebase', $data['token'])
                ->notify(new PushNotification($notificationData));
            
            // Notificare il successo
            FilamentNotification::make()
                ->success()
                ->title(__('notify::push.notifications.sent.title'))
                ->body(__('notify::push.notifications.sent.body'))
                ->send();
                
            // Loggare l'invio
            Log::info('Notifica push inviata con successo', [
                'token' => $data['token'],
                'title' => $data['title'],
                'type' => $data['notification_type'],
            ]);
        } catch (\Exception $e) {
            // Loggare l'errore
            Log::error('Errore durante l\'invio della notifica push', [
                'error' => $e->getMessage(),
                'token' => $data['token'],
            ]);
            
            // Notificare l'errore
            FilamentNotification::make()
                ->danger()
                ->title(__('notify::push.notifications.error.title'))
                ->body($e->getMessage())
                ->send();
        }
    }

    protected function getPushFormActions(): array
    {
        return [
            Action::make('sendPushNotification')
                ->label(__('notify::push.actions.send'))
                ->submit('sendPushNotification'),
        ];
    }

    protected function getUser(): Authenticatable&Model
    {
        $user = Filament::auth()->user();

        if (! $user instanceof Model) {
            throw new \Exception('L\'utente autenticato deve essere un modello Eloquent per consentire l\'aggiornamento del profilo.');
        }

        return $user;
    }
}

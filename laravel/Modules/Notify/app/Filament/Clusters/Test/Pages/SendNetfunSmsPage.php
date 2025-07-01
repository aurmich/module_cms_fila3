<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Clusters\Test\Pages;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Modules\Notify\Datas\SmsData;
use Illuminate\Support\Facades\Log;
use Filament\Forms\ComponentContainer;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Database\Eloquent\Model;
use Modules\Notify\Filament\Clusters\Test;
use Modules\Xot\Filament\Pages\XotBasePage;
use Illuminate\Support\Facades\Notification;
use Illuminate\Contracts\Auth\Authenticatable;
use Filament\Forms\Concerns\InteractsWithForms;
use Modules\Notify\Notifications\SmsNotification;
use Modules\Xot\Filament\Traits\NavigationLabelTrait;
use Filament\Notifications\Notification as FilamentNotification;

/**
 * @property ComponentContainer $smsForm
 */
class SendNetfunSmsPage extends XotBasePage
{

    public ?array $smsData = [];

    protected static ?string $navigationIcon = 'heroicon-o-device-phone-mobile';

    protected static string $view = 'notify::filament.pages.send-sms';

    protected static ?string $cluster = Test::class;
    
    /**
     * Get the slug of the page
     * 
     * This explicit definition ensures consistent URL generation for acronyms
     */
    public static function getSlug(): string
    {
        return 'send-netfun-sms-page';
    }

    public function mount(): void
    {
        $this->fillForms();
    }

    protected function getForms(): array
    {
        return [
            'smsForm',
        ];
    }

    protected function fillForms(): void
    {
        $this->smsForm->fill();
    }

    public function smsForm(Form $form): Form
    {
        return $form
            ->schema($this->getSmsFormSchema())
            ->model($this->getUser())
            ->statePath('smsData');
    }

    public function getSmsFormSchema(): array
    {
        return [
            'to' => Forms\Components\TextInput::make('to')
                ->label(__('notify::sms.form.to.label'))
                ->tel()
                ->required()
                ->helperText(__('notify::sms.form.to.helper'))
                ->placeholder('+393401234567'),
            'from' => Forms\Components\TextInput::make('from')
                ->label(__('notify::sms.form.from.label'))
                ->default('SaluteOra')
                ->required()
                ->maxLength(11)
                ->helperText(__('notify::sms.form.from.helper')),
            'body' => Forms\Components\Textarea::make('body')
                ->label(__('notify::sms.form.body.label'))
                ->required()
                ->rows(3)
                ->helperText(__('notify::sms.form.body.helper')),
            'provider' => Forms\Components\Select::make('provider')
                ->label(__('notify::sms.form.provider.label'))
                ->options([
                    'netfun' => 'Netfun',
                    'smsfactor' => 'SmsFactory',
                    'twilio' => 'Twilio',
                    'nexmo' => 'Nexmo',
                    'plivo' => 'Plivo',
                    'gammu' => 'Gammu',
                ])
                ->default('netfun')
                ->selectablePlaceholder(false)
                ->required(),
        ];
    }

    public function sendSms(): void
    {
        $data = $this->smsForm->getState();

        $smsData = SmsData::from($data);
        /*
        $smsData->to = $data['to'];
        $smsData->from = $data['from'];
        $smsData->body = $data['body'];
        */
        $provider = $data['provider'] ?? 'netfun';

        try {
            Notification::route('sms', $data['to'])
                ->notify(new SmsNotification($smsData, ['provider' => $provider]));

            FilamentNotification::make()
                ->success()
                ->title(__('notify::sms.notifications.sent.title'))
                ->body(__('notify::sms.notifications.sent.body'))
                ->send();

            Log::info('SMS inviato con successo', [
                'to' => $data['to'],
                'from' => $data['from'],
                'provider' => $provider,
            ]);
        } catch (\Exception $e) {
            Log::error('Errore durante l\'invio dell\'SMS', [
                'error' => $e->getMessage(),
                'to' => $data['to'],
                'from' => $data['from'],
                'provider' => $provider,
            ]);

            FilamentNotification::make()
                ->danger()
                ->title(__('notify::sms.notifications.error.title'))
                ->body($e->getMessage())
                ->send();
        }
    }

    protected function getSmsFormActions(): array
    {
        return [
            Action::make('sendSms')
                ->label(__('notify::sms.actions.send'))
                ->submit('sendSms'),
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

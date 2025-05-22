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
use Illuminate\Database\Eloquent\Model;
use Modules\Notify\Enums\SmsDriverEnum;
use Modules\Notify\Filament\Clusters\Test;
use Modules\Xot\Filament\Pages\XotBasePage;
use Illuminate\Support\Facades\Notification;
use Illuminate\Contracts\Auth\Authenticatable;
use Modules\Notify\Notifications\SmsNotification;
use Modules\Notify\Notifications\RecordNotification;
use Modules\Xot\Filament\Traits\NavigationLabelTrait;
use Filament\Notifications\Notification as FilamentNotification;

/**
 * @property ComponentContainer $smsForm
 */
class SendSmsPage extends XotBasePage
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
        return 'send-sms-page';
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
                ->tel()
                ->required()
                ->helperText(__('notify::sms.fields.to.helper_text')),
            'message' => Forms\Components\TextInput::make('message')
                ->required()
                ->maxLength(160)
                ->helperText(__('notify::sms.fields.message.helper_text')),
            'driver' => Forms\Components\Select::make('driver')
                ->options(\Modules\Notify\Enums\SmsDriverEnum::labels())
                ->default(config('sms.default'))
                ->required()
                ->helperText(__('notify::sms.fields.driver.helper_text')),
        ];
    }

    public function sendSMS(): void
    {
        try {
            $data = $this->smsForm->getState();
            $user = $this->getUser();
            /*
            Notification::route('sms', $data['to'])
                ->notify(new SmsNotification($data['message'], [
                    'driver' => $data['driver']
                ]));
            */
            Notification::route('sms', $data['to'])
                //->locale('it')
                ->notify(new RecordNotification($user,'due'));


            FilamentNotification::make()
            ->success()
            // ->title(__('filament-panels::pages/auth/edit-profile.notifications.saved.title'))
            ->title(__('check your email client'))
            ->send();

            FilamentNotification::make()
                ->success()
                ->title('SMS inviato con successo')
                ->send();

        } catch (\Exception $e) {
            //Log::error('Errore nell\'invio SMS: ' . $e->getMessage());

            FilamentNotification::make()
                ->danger()
                ->title('Errore nell\'invio SMS')
                ->body($e->getMessage())
                ->persistent()
                ->send();
        }
    }

    /**
     * Get the form actions for the SMS form.
     *
     * @return array<Action>
     */
    protected function getSmsFormActions(): array
    {
        return [
            Action::make('send')
                ->label(__('notify::sms.actions.send'))
                ->icon('heroicon-o-paper-airplane')
                ->color('primary')
                ->action('sendSMS'),
        ];
    }

    protected function getUser(): Authenticatable&Model
    {
        $user = Filament::auth()->user();

        if (! $user instanceof Model) {
            throw new \Exception('The authenticated user object must be an Eloquent model to allow the profile page to update it.');
        }

        return $user;
    }
}

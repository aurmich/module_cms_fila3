<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Clusters\Test\Pages;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Modules\Notify\Datas\EmailData;
use Illuminate\Support\Facades\Mail;
use Filament\Forms\ComponentContainer;
use Filament\Forms\Contracts\HasForms;
use Modules\Notify\Emails\SpatieEmail;
use Illuminate\Database\Eloquent\Model;
use Modules\Notify\Emails\EmailDataEmail;
use Modules\Notify\Filament\Clusters\Test;
use Modules\Xot\Filament\Pages\XotBasePage;
use Illuminate\Support\Facades\Notification;
use Illuminate\Contracts\Auth\Authenticatable;
use Filament\Forms\Concerns\InteractsWithForms;
use Modules\Notify\Notifications\RecordNotification;
use Modules\Xot\Filament\Traits\NavigationLabelTrait;
use Filament\Notifications\Notification as FilamentNotification;

/**
 * @property ComponentContainer $emailForm
 */
class SendSpatieEmailPage extends XotBasePage
{
    public ?array $emailData = [];
    protected static ?string $navigationIcon = 'heroicon-o-paper-airplane';
    protected static string $view = 'notify::filament.pages.send-email';
    protected static ?string $cluster = Test::class;

    public function mount(): void
    {
        $this->fillForms();
    }

    protected function getForms(): array
    {
        return [
            'emailForm',
        ];
    }

    protected function fillForms(): void
    {
        // $data = $this->getUser()->attributesToArray();

        // $this->editProfileForm->fill($data);
        $this->emailForm->fill();
    }



    public function emailForm(Form $form): Form
    {
        return $form
            ->schema($this->getEmailFormSchema())
            ->model($this->getUser())
            ->statePath('emailData');
    }

    public function getEmailFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('to')
                ->email()
                ->required(),
            Forms\Components\TextInput::make('subject')
                ->required(),
            Forms\Components\RichEditor::make('body_html')
                ->required(),
        ];
    }

    public function sendEmail(): void
    {

        $data = $this->emailForm->getState();
        /*
        $email_data = EmailData::from($data);

        Mail::to($data['to'])->send(
            new EmailDataEmail($email_data)
        );


        */
        $user = $this->getUser();
        $attachments = [
            [
                'path' => '/var/www/html/saluteora/public_html/images/avatars/default-3.svg',
                'as' => 'logo.png',
                'mime' => 'image/png',
            ],
            [
                'path' => '/var/www/html/saluteora/public_html/images/avatars/default-3.svg',
                'as' => 'logo.png',
                'mime' => 'image/png',
            ],
        ];
        //Mail::to($data['to'])->locale('it')->send((new SpatieEmail($user,'due'))->addAttachments($attachments));
        /*
         // Create and send the email
         $email = new SpatieEmail($user, 'uno');
         $email->addAttachments($attachments);

         Mail::to($data['to'])
             ->locale('it')
             ->send($email);
        */

        Notification::route('mail', $data['to'])
            //->locale('it')
            ->notify(new RecordNotification($user,'due'));


        FilamentNotification::make()
        ->success()
        // ->title(__('filament-panels::pages/auth/edit-profile.notifications.saved.title'))
        ->title(__('check your email client'))
        ->send();
    }



    protected function getEmailFormActions(): array
    {
        return [
            Action::make('emailFormActions')
                ->submit('emailFormActions'),
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

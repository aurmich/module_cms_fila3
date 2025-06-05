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
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Modules\Notify\Emails\EmailDataEmail;
use Modules\Notify\Filament\Clusters\Test;
use Modules\Xot\Filament\Pages\XotBasePage;
use Illuminate\Contracts\Auth\Authenticatable;
use Filament\Forms\Concerns\InteractsWithForms;
use Modules\Xot\Filament\Traits\NavigationLabelTrait;


/**
 * @property ComponentContainer $emailForm
 */
class SendEmailPage extends XotBasePage
{

    // use NavigationLabelTrait;

    public ?array $emailData = [];

    protected static ?string $navigationIcon = 'heroicon-o-paper-airplane';

    protected static string $view = 'notify::filament.pages.send-email';

    protected static ?string $cluster = Test::class;

    public function mount(): void
    {
        $this->fillForms();
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
            'section' => Forms\Components\Section::make()
                // ->description('Update your account\'s profile information and email address.')
                ->schema([
                    'to' => Forms\Components\TextInput::make('to')
                        // ->unique(ignoreRecord: true)
                        ->email()
                        ->required(),
                    'subject' => Forms\Components\TextInput::make('subject')
                        ->required(),
                    'body_html' => Forms\Components\RichEditor::make('body_html')
                        ->required(),
                ]),
        ];
    }

    public function sendEmail(): void
    {
        $data = $this->emailForm->getState();
        $email_data = EmailData::from($data);

        Mail::to($data['to'])->send(
            new EmailDataEmail($email_data)
        );

        Notification::make()
            ->success()
            // ->title(__('filament-panels::pages/auth/edit-profile.notifications.saved.title'))
            ->title(__('check your email client'))
            ->send();
    }

    protected function getForms(): array
    {
        return [
            'emailForm',
        ];
    }

    protected function getEmailFormActions(): array
    {
        return [
            Action::make('emailFormActions')
                //

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

    protected function fillForms(): void
    {
        // $data = $this->getUser()->attributesToArray();

        // $this->editProfileForm->fill($data);
        $this->emailForm->fill();
    }
}

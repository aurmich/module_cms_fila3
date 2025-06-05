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
use Modules\Notify\Emails\EmailDataEmail;
use Modules\Notify\Filament\Clusters\Test;
use Modules\Xot\Filament\Pages\XotBasePage;
use Illuminate\Contracts\Auth\Authenticatable;
use Filament\Forms\Concerns\InteractsWithForms;
use Modules\Xot\Filament\Traits\NavigationLabelTrait;
use Filament\Notifications\Notification as FilamentNotification;

/**
 * @property ComponentContainer $emailForm
 */
class SendAwsEmailPage extends XotBasePage
{

    public ?array $emailData = [];

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static string $view = 'notify::filament.pages.send-email';

    protected static ?string $cluster = Test::class;
    
    /**
     * Get the slug of the page
     * 
     * This explicit definition ensures consistent URL generation for acronyms
     */
    public static function getSlug(): string
    {
        return 'send-aws-email-page';
    }

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
                ->label(__('notify::email.form.to.label'))
                ->email()
                ->required()
                ->helperText(__('notify::email.form.to.helper')),
            Forms\Components\TextInput::make('subject')
                ->label(__('notify::email.form.subject.label'))
                ->required()
                ->maxLength(150),
            Forms\Components\RichEditor::make('body_html')
                ->label(__('notify::email.form.body_html.label'))
                ->required()
                ->fileAttachmentsDisk('public')
                ->fileAttachmentsDirectory('uploads/mail-attachments')
                ->helperText(__('notify::email.form.body_html.helper')),
            Forms\Components\Select::make('template')
                ->label(__('notify::email.form.template.label'))
                ->options([
                    'aws-default' => 'AWS Default',
                    'aws-notification' => 'AWS Notification',
                    'aws-receipt' => 'AWS Receipt',
                    'aws-alert' => 'AWS Alert',
                ])
                ->default('aws-default')
                ->required()
                ->helperText(__('notify::email.form.template.helper')),
            Forms\Components\Toggle::make('add_attachments')
                ->label(__('notify::email.form.add_attachments.label'))
                ->default(false)
                ->helperText(__('notify::email.form.add_attachments.helper')),
        ];
    }

    public function sendEmail(): void
    {
        $data = $this->emailForm->getState();

        try {
            $emailData = new EmailData(
                to: $data['to'],
                subject: $data['subject'],
                bodyHtml: $data['body_html'],
                templateName: $data['template']
            );

            // Configurare lo specifico driver AWS SES per questo test
            config(['mail.default' => 'ses']);

            // Aggiungere degli allegati di esempio se richiesto
            $attachments = [];
            if ($data['add_attachments'] ?? false) {
                $attachments = [
                    [
                        'path' => public_path('images/logo.png'),
                        'as' => 'logo.png',
                        'mime' => 'image/png',
                    ],
                    [
                        'path' => public_path('docs/example.pdf'),
                        'as' => 'example.pdf',
                        'mime' => 'application/pdf',
                    ],
                ];
            }

            // Invia l'email utilizzando il servizio SES
            Mail::to($data['to'])
                ->send(new EmailDataEmail($emailData, $attachments));

            FilamentNotification::make()
                ->success()
                ->title(__('notify::email.notifications.sent.title'))
                ->body(__('notify::email.notifications.sent.body'))
                ->send();
        } catch (\Exception $e) {
            FilamentNotification::make()
                ->danger()
                ->title(__('notify::email.notifications.error.title'))
                ->body($e->getMessage())
                ->send();
        }
    }

    protected function getEmailFormActions(): array
    {
        return [
            Action::make('sendEmail')
                ->label(__('notify::email.actions.send'))
                ->submit('sendEmail'),
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

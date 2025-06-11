<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets\Auth;

use Filament\Forms\Form;
use Filament\Forms\ComponentContainer;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Password;
use Modules\Xot\Filament\Widgets\XotBaseWidget;
use Filament\Forms\Components\TextInput as FormsTextInput;

/**
 * @property ComponentContainer $form
 */
class ForgotPasswordWidget extends XotBaseWidget
{
    protected static string $view = 'user::widgets.auth.forgot-password-widget';

    /**
     * Get the form schema for this widget.
     *
     * @return array<string, \Filament\Forms\Components\Component>
     */
    public function getFormSchema(): array
    {
        return [
            'email' => TextInput::make('email')
                ->email()
                ->required()
                ->maxLength(255),
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                    ])
                    ->columns(1),
            ])
            ->statePath('data');
    }

    public function sendResetLink(): void
    {
        $data = $this->form->getState();

        $status = Password::sendResetLink(
            ['email' => $data['email']]
        );

        if ($status === Password::RESET_LINK_SENT) {
            session()->flash('status', __($status));
        } else {
            $this->addError('email', __($status));
        }
    }
}

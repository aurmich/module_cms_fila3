<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets\Auth;

use Filament\Forms;
use Filament\Forms\Form;
use Illuminate\Support\Str;
use Webmozart\Assert\Assert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\ComponentContainer;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

/**
 * Password Reset Confirmation Widget for SaluteOra platform.
 * 
 * Handles the password reset confirmation flow using a token
 * from the password reset email link.
 * 
 * @property ComponentContainer $form
 */
class PasswordResetConfirmWidget extends XotBaseWidget
{
    public ?array $data = [];
    public ?string $token = null;
    public ?string $email = null;
    public string $currentState = 'form'; // form, success, error, expired
    public ?string $errorMessage = null;

    protected static string $view = 'pub_theme::filament.widgets.auth.password.reset-confirm';

    /**
     * Mount the widget with token and optional email.
     *
     * @param string|null $token
     * @param string|null $email
     * @return void
     */
    public function mount(?string $token = null, ?string $email = null): void
    {
        $this->token = $token;
        $this->email = $email;
        
        // Pre-fill the form if email is provided
        if ($this->email) {
            $this->form->fill(['email' => $this->email]);
        }
    }

    /**
     * Get the form schema for password reset confirmation.
     *
     * @return array<string, mixed>
     */
    public function getFormSchema(): array
    {
        return [
                    'email'=>Forms\Components\TextInput::make('email')
                        ->email()
                        ->required()
                        ->autocomplete('email')
                        ->maxLength(255)
                        ->disabled($this->currentState !== 'form')
                        ->extraInputAttributes(['class' => 'text-center'])
                        ->suffixIcon('heroicon-o-envelope'),

                    'password'=>Forms\Components\TextInput::make('password')
                        ->password()
                        ->required()
                        ->revealable()
                        ->minLength(8)
                        ->disabled($this->currentState !== 'form')
                        ->extraInputAttributes(['class' => 'text-center'])
                        ->suffixIcon('heroicon-o-key')
                        ,

                    'password_confirmation'=>Forms\Components\TextInput::make('password_confirmation')
                        ->password()
                        ->required()
                        ->same('password')
                        ->disabled($this->currentState !== 'form')
                        ->extraInputAttributes(['class' => 'text-center'])
                        ->suffixIcon('heroicon-o-key'),
        ];
    }

    /**
     * Handle the password reset confirmation.
     *
     * @return void
     */
    public function confirmPasswordReset(): void
    {
        if ($this->currentState !== 'form') {
            return;
        }

        $this->currentState = 'loading';

        try {
            $data = $this->form->getState();
            
            $response = Password::broker()->reset(
                [
                    'token' => $this->token,
                    'email' => $data['email'],
                    'password' => $data['password'],
                ],
                function ($user, $password) {
                    $user->password = Hash::make($password);
                    $user->setRememberToken(Str::random(60));
                    $user->save();

                    event(new PasswordReset($user));
                }
            );

            if ($response === Password::PASSWORD_RESET) {
                $this->currentState = 'success';
                
                Notification::make()
                    ->title(__('user::auth.password_reset.success.title'))
                    ->body(__('user::auth.password_reset.success.message'))
                    ->success()
                    ->duration(8000)
                    ->send();

                // Auto-login the user after successful password reset
                //$user = \Modules\Xot\Datas\XotData::make()->getUserClass()::where('email', $data['email'])->first();
                Assert::string($email = $data['email']);
                $user = \Modules\Xot\Datas\XotData::make()->getUserByEmail($email);
                //if ($user) {
                    Auth::guard()->login($user);
                //}

                // Redirect after a short delay to show success message
                $this->js('setTimeout(() => { window.location.href = "' . route('login') . '"; }, 3000);');

            } else {
                /** @phpstan-ignore-next-line */
                $this->handleResetError($response);
            }

        } catch (\Exception $e) {
            $this->handleResetError('passwords.generic_error');
        }
    }

    /**
     * Handle password reset errors.
     *
     * @param string $response
     * @return void
     */
    protected function handleResetError(string $response): void
    {
        $this->currentState = 'error';
        
        // Map Laravel password reset responses to user-friendly messages
        $errorMessages = [
            Password::INVALID_TOKEN => __('user::auth.password_reset.errors.invalid_token'),
            Password::INVALID_USER => __('user::auth.password_reset.errors.invalid_user'),
            'passwords.generic_error' => __('user::auth.password_reset.errors.generic'),
        ];

        $this->errorMessage = $errorMessages[$response] ?? trans($response);

        Notification::make()
            ->title(__('user::auth.password_reset.errors.title'))
            ->body($this->errorMessage)
            ->danger()
            ->duration(10000)
            ->send();
    }

    /**
     * Reset the widget to allow another attempt.
     *
     * @return void
     */
    public function resetForm(): void
    {
        $this->currentState = 'form';
        $this->errorMessage = null;
        $this->form->fill(['email' => $this->email ?? '']);
    }

    /**
     * Get the current state for the view.
     *
     * @return string
     */
    public function getCurrentState(): string
    {
        return $this->currentState;
    }

    /**
     * Get the error message if any.
     *
     * @return string|null
     */
    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }

    /**
     * Check if the form should be shown.
     *
     * @return bool
     */
    public function shouldShowForm(): bool
    {
        return in_array($this->currentState, ['form', 'loading']);
    }

    /**
     * Check if the widget is in loading state.
     *
     * @return bool
     */
    public function isLoading(): bool
    {
        return $this->currentState === 'loading';
    }

    /**
     * Check if the password reset was successful.
     *
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->currentState === 'success';
    }

    /**
     * Check if there was an error.
     *
     * @return bool
     */
    public function hasError(): bool
    {
        return $this->currentState === 'error';
    }
} 
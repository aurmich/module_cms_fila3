<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets\Auth;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\ComponentContainer;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Notifications\Notification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Validation\ValidationException;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

/**
 * Reset password widget for user password reset functionality.
 * 
 * Handles password reset form with token validation and secure password update.
 *
 * @property ComponentContainer $form
 * @property array<string, mixed>|null $data
 */
class ResetPasswordWidget extends XotBaseWidget implements HasForms
{
    use InteractsWithForms;

    /**
     * The view for this widget.
     *
     * @var view-string
     */
    protected static string $view = 'user::widgets.auth.reset-password-widget';

    /**
     * Widget data array.
     * 
     * CRITICAL: Do not remove or redeclare this property - it's managed by XotBaseWidget.
     *
     * @var array<string, mixed>|null
     */
    public ?array $data = [];

    /**
     * Column span for the widget layout.
     *
     * @var int|string|array<string, mixed>
     */
    protected int | string | array $columnSpan = 'full';

    /**
     * Reset token from the request.
     *
     * @var string|null
     */
    public ?string $token = null;

    /**
     * Get the form schema for password reset.
     *
     * @return array<string, \Filament\Forms\Components\Component>
     */
    public function getFormSchema(): array
    {
        return [
            'token' => Hidden::make('token')
                ->default($this->token),
                
            'email' => TextInput::make('email')
                ->email()
                ->required()
                ->maxLength(255)
                ->autocomplete('email')
                ->validationAttribute(__('user::auth.fields.email.validation_attribute')),
                
            'password' => TextInput::make('password')
                ->password()
                ->required()
                ->rule(PasswordRule::default())
                ->same('password_confirmation')
                ->autocomplete('new-password')
                ->validationAttribute(__('user::auth.fields.password.validation_attribute')),
                
            'password_confirmation' => TextInput::make('password_confirmation')
                ->password()
                ->required()
                ->dehydrated(false)
                ->autocomplete('new-password')
                ->validationAttribute(__('user::auth.fields.password_confirmation.validation_attribute')),
        ];
    }

    /**
     * Mount the widget and initialize the form.
     *
     * @param string|null $token
     * @param string|null $email
     * @return void
     */
    public function mount(?string $token = null, ?string $email = null): void
    {
        $this->token = $token ?? (string) request()->route('token');
        
        $this->form->fill([
            'token' => $this->token,
            'email' => $email ?? (string) request()->query('email'),
        ]);
    }

    /**
     * Configure the form for this widget.
     *
     * @param \Filament\Forms\Form $form
     * @return \Filament\Forms\Form
     */
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('user::auth.reset_password.section_title'))
                    ->description(__('user::auth.reset_password.section_description'))
                    ->schema($this->getFormSchema())
                    ->columns(1),
            ])
            ->statePath('data');
    }

    /**
     * Handle password reset with comprehensive error handling.
     *
     * @return \Illuminate\Http\RedirectResponse|\Livewire\Features\SupportRedirects\Redirector
     */
    public function resetPassword(): \Illuminate\Http\RedirectResponse|\Livewire\Features\SupportRedirects\Redirector
    {
        try {
            $this->validate();
            $data = $this->form->getState();

            // Type-safe data extraction
            $email = (string) ($data['email'] ?? '');
            $password = (string) ($data['password'] ?? '');
            $passwordConfirmation = (string) ($data['password_confirmation'] ?? '');
            $token = (string) ($data['token'] ?? $this->token ?? '');

            if (empty($email) || empty($password) || empty($token)) {
                throw ValidationException::withMessages([
                    'email' => [__('user::auth.validation.required_fields')],
                ]);
            }

            // Attempt password reset
            $status = Password::reset(
                [
                    'email' => $email,
                    'password' => $password,
                    'password_confirmation' => $passwordConfirmation,
                    'token' => $token,
                ],
                function ($user, $password): void {
                    $user->forceFill([
                        'password' => Hash::make($password),
                        'remember_token' => Str::random(60),
                    ])->save();

                    // Log successful password reset
                    Log::info('Password reset successfully', [
                        'user_id' => $user->id,
                        'email' => $user->email,
                    ]);
                }
            );

            if ($status === Password::PASSWORD_RESET) {
                // Show success notification
                Notification::make()
                    ->title(__('user::auth.reset_password.success'))
                    ->success()
                    ->send();

                session()->flash('status', __((string) $status));
                return redirect()->route('login');
            } else {
                // Handle password reset failure
                $this->addError('email', __((string) $status));
                
                Log::warning('Password reset failed', [
                    'email' => $email,
                    'status' => $status,
                ]);
                
                return redirect()->back();
            }

        } catch (ValidationException $e) {
            // Re-throw validation exceptions to display form errors
            throw $e;
        } catch (\Exception $e) {
            // Log unexpected errors
            Log::error('Password reset error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Show user-friendly error message
            Notification::make()
                ->title(__('user::auth.reset_password.error'))
                ->body(__('user::auth.reset_password.error_message'))
                ->danger()
                ->send();

            return redirect()->back();
        }
    }
}

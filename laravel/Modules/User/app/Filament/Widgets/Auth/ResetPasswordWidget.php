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
use Webmozart\Assert\Assert;

/**
 * Reset password widget for user password reset functionality.
 * 
 * Handles password reset form with token validation and secure password update.
 * Follows Laraxot patterns with comprehensive error handling and type safety.
 *
 * @property ComponentContainer $form
 * @property array<string, mixed>|null $data
 * @property string|null $token
 *
 * @extends XotBaseWidget
 */
final class ResetPasswordWidget extends XotBaseWidget implements HasForms
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
                ->default($this->token)
                ->required(),
                
            'email' => TextInput::make('email')
                ->email()
                ->required()
                ->maxLength(255)
                ->autocomplete('email')
                ->validationAttribute(__('user::auth.fields.email.validation_attribute'))
                ->helperText(__('user::auth.reset_password.email_helper')),
                
            'password' => TextInput::make('password')
                ->password()
                ->required()
                ->rule(PasswordRule::default())
                ->minLength(8)
                ->same('password_confirmation')
                ->autocomplete('new-password')
                ->validationAttribute(__('user::auth.fields.password.validation_attribute'))
                ->helperText(__('user::auth.fields.password.helper_text')),
                
            'password_confirmation' => TextInput::make('password_confirmation')
                ->password()
                ->required()
                ->minLength(8)
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
        // Validate and sanitize token
        $routeToken = request()->route('token');
        $this->token = $token ?? (is_string($routeToken) ? $routeToken : '');
        
        Assert::stringNotEmpty($this->token, 'Password reset token is required');
        
        // Validate and sanitize email
        $queryEmail = request()->query('email');
        $emailValue = $email ?? (is_string($queryEmail) ? $queryEmail : '');
        
        if (!empty($emailValue)) {
            Assert::true(
                filter_var($emailValue, FILTER_VALIDATE_EMAIL) !== false, 
                'Invalid email format provided'
            );
        }
        
        $this->form->fill([
            'token' => $this->token,
            'email' => $emailValue,
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
     * Handle password reset with comprehensive error handling and type safety.
     *
     * @return \Illuminate\Http\RedirectResponse|\Livewire\Features\SupportRedirects\Redirector
     * 
     * @throws \Illuminate\Validation\ValidationException
     */
    public function resetPassword(): \Illuminate\Http\RedirectResponse|\Livewire\Features\SupportRedirects\Redirector
    {
        try {
            $this->validate();
            $data = $this->form->getState();

            // Type-safe data extraction with rigorous validation
            Assert::isArray($data, 'Form data must be an array');
            Assert::keyExists($data, 'email', 'Email is required');
            Assert::keyExists($data, 'password', 'Password is required');
            Assert::keyExists($data, 'password_confirmation', 'Password confirmation is required');
            
            $email = $this->extractStringValue($data, 'email');
            $password = $this->extractStringValue($data, 'password');
            $passwordConfirmation = $this->extractStringValue($data, 'password_confirmation');
            $token = $this->extractStringValue($data, 'token');

            // Validate extracted values
            Assert::stringNotEmpty($email, 'Email cannot be empty');
            Assert::stringNotEmpty($password, 'Password cannot be empty');
            Assert::stringNotEmpty($passwordConfirmation, 'Password confirmation cannot be empty');
            Assert::stringNotEmpty($token, 'Reset token cannot be empty');
            
            // Validate email format
            Assert::true(
                filter_var($email, FILTER_VALIDATE_EMAIL) !== false, 
                'Invalid email format'
            );
            
            // Validate password confirmation
            Assert::same($password, $passwordConfirmation, 'Password confirmation does not match');

            // Attempt password reset using Laravel's built-in system
            $status = Password::reset(
                [
                    'email' => $email,
                    'password' => $password,
                    'password_confirmation' => $passwordConfirmation,
                    'token' => $token,
                ],
                function ($user, $password): void {
                    Assert::notNull($user, 'User is required for password reset');
                    Assert::stringNotEmpty($password, 'New password cannot be empty');
                    
                    // Update user password with secure hash
                    $user->forceFill([
                        'password' => Hash::make($password),
                        'remember_token' => Str::random(60),
                    ])->save();

                    // Log successful password reset for audit trail
                    Log::info('Password reset successfully completed', [
                        'user_id' => $user->id ?? 'unknown',
                        'email' => $user->email ?? 'unknown',
                        'ip_address' => request()->ip(),
                        'user_agent' => request()->userAgent(),
                    ]);
                }
            );

            Assert::string($status, 'Password reset status must be a string');

            if ($status === Password::PASSWORD_RESET) {
                // Show success notification
                Notification::make()
                    ->title(__('user::auth.reset_password.success'))
                    ->body(__('user::auth.reset_password.success_message'))
                    ->success()
                    ->send();

                // Flash success message for the login page
                session()->flash('status', __($status));
                
                return redirect()->route('login');
            } else {
                // Handle password reset failure with specific error logging
                $this->addError('email', __($status));
                
                Log::warning('Password reset failed', [
                    'email' => $email,
                    'status' => $status,
                    'token' => substr($token, 0, 8) . '...', // Partial token for security
                    'ip_address' => request()->ip(),
                ]);
                
                return redirect()->back();
            }

        } catch (ValidationException $e) {
            // Re-throw validation exceptions to display form errors
            Log::warning('Password reset validation failed', [
                'errors' => $e->errors(),
                'email' => $data['email'] ?? 'unknown',
                'token_present' => isset($data['token']),
            ]);
            throw $e;
            
        } catch (\Webmozart\Assert\InvalidArgumentException $e) {
            // Handle assertion failures with detailed logging
            Log::error('Password reset assertion failed', [
                'error' => $e->getMessage(),
                'data_keys' => array_keys($data ?? []),
                'token_present' => isset($data['token']),
                'trace' => $e->getTraceAsString(),
            ]);

            Notification::make()
                ->title(__('user::auth.reset_password.validation_error'))
                ->body(__('user::auth.reset_password.validation_error_message'))
                ->danger()
                ->send();

            return redirect()->back();
            
        } catch (\Exception $e) {
            // Log unexpected errors with comprehensive context
            Log::error('Password reset failed with unexpected error', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'data_structure' => isset($data) ? array_keys($data) : 'unknown',
                'token_length' => isset($this->token) ? strlen($this->token) : 0,
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

    /**
     * Extract a string value from array data with comprehensive type safety.
     *
     * @param array<string, mixed> $data
     * @param string $key
     * @return string
     * 
     * @throws \Webmozart\Assert\InvalidArgumentException
     */
    private function extractStringValue(array $data, string $key): string
    {
        Assert::keyExists($data, $key, "Key '{$key}' is required in form data");
        
        $value = $data[$key];
        
        // Handle string values (most common case)
        if (is_string($value)) {
            return trim($value);
        }
        
        // Handle null values
        if ($value === null) {
            throw new \Webmozart\Assert\InvalidArgumentException(
                "Value for key '{$key}' cannot be null"
            );
        }
        
        // Handle scalar values with safe conversion
        if (is_scalar($value)) {
            $stringValue = trim((string) $value);
            Assert::stringNotEmpty($stringValue, "Value for key '{$key}' cannot be empty after conversion");
            return $stringValue;
        }
        
        // Reject complex types
        throw new \Webmozart\Assert\InvalidArgumentException(
            "Value for key '{$key}' must be a string, " . gettype($value) . ' given'
        );
    }
}

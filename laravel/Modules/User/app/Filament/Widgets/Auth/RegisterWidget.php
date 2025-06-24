<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets\Auth;

use Filament\Forms\Form;
use Filament\Forms\ComponentContainer;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Modules\User\Models\User;
use Modules\Xot\Filament\Widgets\XotBaseWidget;
use Webmozart\Assert\Assert;

/**
 * Register widget for user registration functionality.
 * 
 * Provides a complete registration form with validation, user creation,
 * and automatic login upon successful registration. Follows Laraxot patterns
 * with XotBaseWidget extension and robust error handling.
 *
 * @property ComponentContainer $form
 * @property array<string, mixed>|null $data
 *
 * @extends XotBaseWidget
 */
final class RegisterWidget extends XotBaseWidget implements HasForms
{
    use InteractsWithForms;

    /**
     * The view for this widget.
     *
     * @var view-string
     */
    protected static string $view = 'user::widgets.auth.register-widget';

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
     * Get the form schema for this widget.
     *
     * @return array<string, \Filament\Forms\Components\Component>
     */
    public function getFormSchema(): array
    {
        return [
            'name' => TextInput::make('name')
                ->required()
                ->string()
                ->minLength(2)
                ->maxLength(255)
                ->autocomplete('name')
                ->validationAttribute(__('user::auth.fields.name.validation_attribute'))
                ->helperText(__('user::auth.fields.name.helper_text')),
                
            'email' => TextInput::make('email')
                ->email()
                ->required()
                ->unique(table: User::class)
                ->maxLength(255)
                ->autocomplete('email')
                ->validationAttribute(__('user::auth.fields.email.validation_attribute'))
                ->helperText(__('user::auth.fields.email.helper_text')),
                
            'password' => TextInput::make('password')
                ->password()
                ->required()
                ->rule(Password::default())
                ->minLength(8)
                ->autocomplete('new-password')
                ->validationAttribute(__('user::auth.fields.password.validation_attribute'))
                ->helperText(__('user::auth.fields.password.helper_text')),
                
            'password_confirmation' => TextInput::make('password_confirmation')
                ->password()
                ->required()
                ->same('password')
                ->minLength(8)
                ->autocomplete('new-password')
                ->dehydrated(false)
                ->validationAttribute(__('user::auth.fields.password_confirmation.validation_attribute')),
        ];
    }

    /**
     * Mount the widget and initialize the form.
     *
     * @return void
     */
    public function mount(): void
    {
        $this->form->fill();
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
                Section::make(__('user::auth.registration.section_title'))
                    ->description(__('user::auth.registration.section_description'))
                    ->schema($this->getFormSchema())
                    ->columns(1),
            ])
            ->statePath('data');
    }

    /**
     * Handle user registration with comprehensive error handling and type safety.
     *
     * @return \Illuminate\Http\RedirectResponse|\Livewire\Features\SupportRedirects\Redirector
     * 
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(): \Illuminate\Http\RedirectResponse|\Livewire\Features\SupportRedirects\Redirector
    {
        try {
            $this->validate();
            $data = $this->form->getState();

            // Type-safe data extraction with explicit validation
            Assert::isArray($data, 'Form data must be an array');
            Assert::keyExists($data, 'name', 'Name is required');
            Assert::keyExists($data, 'email', 'Email is required');
            Assert::keyExists($data, 'password', 'Password is required');
            
            $name = $this->extractStringValue($data, 'name');
            $email = $this->extractStringValue($data, 'email');
            $password = $this->extractStringValue($data, 'password');

            Assert::stringNotEmpty($name, 'Name cannot be empty');
            Assert::stringNotEmpty($email, 'Email cannot be empty');
            Assert::stringNotEmpty($password, 'Password cannot be empty');
            
            // Additional email validation
            Assert::true(filter_var($email, FILTER_VALIDATE_EMAIL) !== false, 'Invalid email format');

            // Create user with proper type casting and validation
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'email_verified_at' => null, // Will be verified separately if needed
            ]);

            Assert::notNull($user, 'User creation failed');
            Assert::notNull($user->id, 'User ID is required');

            // Log successful registration for audit trail
            Log::info('User registered successfully', [
                'user_id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            // Authenticate the new user
            Auth::login($user);

            // Show success notification
            Notification::make()
                ->title(__('user::auth.registration.success'))
                ->body(__('user::auth.registration.success_message', ['name' => $user->name]))
                ->success()
                ->send();

            // Redirect to intended location or dashboard
            $intendedUrl = session()->pull('url.intended', route('dashboard'));
            Assert::string($intendedUrl, 'Intended URL must be a string');
            
            return redirect()->to($intendedUrl);

        } catch (ValidationException $e) {
            // Re-throw validation exceptions to display form errors
            Log::warning('Registration validation failed', [
                'errors' => $e->errors(),
                'email' => $data['email'] ?? 'unknown',
            ]);
            throw $e;
            
        } catch (\Webmozart\Assert\InvalidArgumentException $e) {
            // Handle assertion failures
            Log::error('Registration assertion failed', [
                'error' => $e->getMessage(),
                'data' => $data ?? [],
                'trace' => $e->getTraceAsString(),
            ]);

            Notification::make()
                ->title(__('user::auth.registration.validation_error'))
                ->body(__('user::auth.registration.validation_error_message'))
                ->danger()
                ->send();

            return redirect()->back();
            
        } catch (\Exception $e) {
            // Log unexpected errors with full context
            Log::error('Registration failed with unexpected error', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'data' => $data ?? [],
            ]);

            // Show user-friendly error message
            Notification::make()
                ->title(__('user::auth.registration.error'))
                ->body(__('user::auth.registration.error_message'))
                ->danger()
                ->send();

            return redirect()->back();
        }
    }

    /**
     * Extract a string value from array data with type safety.
     *
     * @param array<string, mixed> $data
     * @param string $key
     * @return string
     * 
     * @throws \Webmozart\Assert\InvalidArgumentException
     */
    private function extractStringValue(array $data, string $key): string
    {
        Assert::keyExists($data, $key, "Key '{$key}' is required");
        
        $value = $data[$key];
        
        if (is_string($value)) {
            return trim($value);
        }
        
        // Handle null or other types gracefully
        if ($value === null) {
            throw new \Webmozart\Assert\InvalidArgumentException("Value for key '{$key}' cannot be null");
        }
        
        // Attempt safe conversion to string
        if (is_scalar($value)) {
            return trim((string) $value);
        }
        
        throw new \Webmozart\Assert\InvalidArgumentException("Value for key '{$key}' must be a string, " . gettype($value) . ' given');
    }
}

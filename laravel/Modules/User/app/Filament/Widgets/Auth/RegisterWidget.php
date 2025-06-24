<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets\Auth;

use Filament\Forms\Form;
use Filament\Forms\ComponentContainer;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Grid;
use Filament\Notifications\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Stringable;
use Illuminate\Validation\Rules\Password;
use Modules\User\Models\User;
use Modules\Xot\Filament\Widgets\XotBaseWidget;
use Webmozart\Assert\Assert;
use Webmozart\Assert\InvalidArgumentException;

/**
 * Registration widget for new user creation in the system.
 *
 * Implements secure user registration with comprehensive validation,
 * error handling, and logging following Laraxot architectural patterns.
 *
 * @property ComponentContainer $form Form container from XotBaseWidget
 * @property array<string, mixed>|null $data Form data array
 *
 * @method static static make()
 */
class RegisterWidget extends XotBaseWidget
{
    /**
     * The view for this widget.
     *
     * @var view-string
     */
    protected static string $view = 'user::widgets.auth.register-widget';

    /**
     * Sort order for dashboard display.
     *
     * @var int|null
     */
    protected static ?int $sort = 2;

    /**
     * Maximum height configuration for widget.
     *
     * @var string|null
     */
    protected static ?string $maxHeight = '600px';

    /**
     * Access control - only non-authenticated users can view.
     *
     * @return bool
     */
    public static function canView(): bool
    {
        return !Auth::check();
    }

    /**
     * Mount the widget and initialize the form.
     *
     * @return void
     */
    public function mount(): void
    {
        $this->form->fill([]);
        
        Log::info('RegisterWidget mounted', [
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Get the form schema for user registration.
     *
     * Implements a comprehensive registration form with client and server-side validation.
     * Follows Filament's form component structure with proper type hints and documentation.
     *
     * @return array<string, \Filament\Forms\Components\Component>
     */
    public function getFormSchema(): array
    {
        return [
            'user_info' => Section::make()
                ->schema([
                    'first_name' => TextInput::make('first_name')
                        ->label(__('user::auth.fields.first_name'))
                        ->required()
                        ->string()
                        ->minLength(2)
                        ->maxLength(255)
                        ->autocomplete('given-name')
                        ->validationAttribute(__('user::auth.fields.first_name')),
                    
                    'last_name' => TextInput::make('last_name')
                        ->label(__('user::auth.fields.last_name'))
                        ->required()
                        ->string()
                        ->minLength(2)
                        ->maxLength(255)
                        ->autocomplete('family-name')
                        ->validationAttribute(__('user::auth.fields.last_name')),
                    
                    'email' => TextInput::make('email')
                        ->label(__('user::auth.fields.email'))
                        ->required()
                        ->email()
                        ->maxLength(255)
                        ->unique(User::class, 'email')
                        ->autocomplete('email')
                        ->validationAttribute(__('user::auth.fields.email'))
                        ->helperText(__('user::auth.help.email'))
                        ->unique(User::class, 'email')
                        ->maxLength(255),
                    
                    'password_grid' => Grid::make(2)
                        ->schema([
                            'password' => TextInput::make('password')
                                ->label(__('user::auth.fields.password'))
                                ->password()
                                ->required()
                                ->string()
                                ->minLength(12)
                                ->maxLength(255)
                                ->rules([
                                    'required',
                                    'string',
                                    'min:12',
                                    'regex:/[A-Z]/',      // At least one uppercase letter
                                    'regex:/[a-z]/',      // At least one lowercase letter
                                    'regex:/[0-9]/',      // At least one number
                                    'regex:/[^A-Za-z0-9]/' // At least one special character
                                ])
                                ->validationMessages([
                                    'password.regex' => __('user::auth.validation.password.complexity'),
                                ])
                                ->autocomplete('new-password')
                                ->validationAttribute(__('user::auth.fields.password'))
                                ->helperText(__('user::auth.help.password'))
                                ->confirmed(),
                            
                            'password_confirmation' => TextInput::make('password_confirmation')
                                ->label(__('user::auth.fields.password_confirmation'))
                                ->password()
                                ->required()
                                ->string()
                                ->minLength(12)
                                ->maxLength(255)
                                ->autocomplete('new-password')
                                ->validationAttribute(__('user::auth.fields.password_confirmation'))
                                ->dehydrated(false)
                                ->same('password'),
                        ]),
                ]),
                
            'preferences' => Section::make()
                ->schema([
                    'user_type' => Select::make('type')
                        ->options($this->getUserTypeOptions())
                        ->required(),
                ]),
        ];
    }

    /**
     * Get user type options for registration.
     *
     * @return array<string, string>
     */
    protected function getUserTypeOptions(): array
    {
        $userTypes = config('moderation.user_types', []);
        $options = [];
        
        foreach ($userTypes as $key => $config) {
            $options[$key] = $config['label'] ?? ucfirst($key);
        }
        
        return $options ?: [
            'standard' => 'Standard User',
            'professional' => 'Professional',
        ];
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
            ->schema($this->getFormSchema())
            ->statePath('data')
            ->operation('create');
    }

    /**
     * Handle form submission with comprehensive error handling and validation.
     *
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     * @throws \RuntimeException
     */
    public function submit(): void
    {
        try {
            // Validate form data first
            $validatedData = $this->validateForm();
            
            // Log registration attempt with hashed PII for security
            $this->logRegistrationAttempt($validatedData);
            
            // Begin database transaction for data integrity
            $user = \DB::transaction(function () use ($validatedData) {
                // Create user with validated data
                $user = $this->createUser($validatedData);
                
                // Trigger any post-registration events
                $this->afterUserCreated($user);
                
                return $user;
            });
            
            // Log successful registration with user ID
            Log::info('User registered successfully', [
                'user_id' => $user->id,
                'email_hash' => hash('sha256', $user->email),
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
            
            // Send email verification if needed
            if (config('auth.must_verify_email')) {
                $user->sendEmailVerificationNotification();
            }
            
            // Log in the user
            Auth::login($user);
            
            // Redirect to intended URL or dashboard
            $this->redirectAfterRegistration($user);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Re-throw validation exceptions to be handled by Filament
            throw $e;
            
        } catch (\Exception $e) {
            // Log detailed error information
            Log::error('Registration failed: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
            
            // Show user-friendly error message
            $this->dispatchBrowserEvent('registration-failed', [
                'message' => __('user::auth.registration.failed')
            ]);
            
            // Re-throw with a generic message for the UI
            throw new \RuntimeException(__('user::auth.registration.error_occurred'));
        }
    }

    /**
     * Validate form data before registration.
     *
     * @return array<string, mixed>
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateForm(): array
    {
        $data = $this->form->getState();
        
        // Hash password securely
        $data['password'] = Hash::make((string) $data['password']);
        
        // Create user with safe data
        $userData = [
            'first_name' => (string) $data['first_name'],
            'last_name' => (string) $data['last_name'],
            'email' => (string) $data['email'],
            'password' => $data['password'],
            'type' => (string) ($data['type'] ?? 'standard'),
            'state' => 'pending',
            'email_verified_at' => null,
        ];
        
        return $userData;
    }

    /**
     * Log registration attempt with hashed PII for security.
     *
     * @param array<string, mixed> $validatedData
     * @return void
     */
    protected function logRegistrationAttempt(array $validatedData): void
    {
        Log::info('Registration attempt', [
            'email_hash' => hash('sha256', $validatedData['email']),
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Create user with validated data.
     *
     * @param array<string, mixed> $validatedData
     * @return User
     */
    protected function createUser(array $validatedData): User
    {
        return User::create($validatedData);
    }

    /**
     * Trigger any post-registration events.
     *
     * @param User $user
     * @return void
     */
    protected function afterUserCreated(User $user): void
    {
        // Activity logging for audit trail
        activity()
            ->causedBy($user)
            ->performedOn($user)
            ->withProperties([
                'type' => $user->type,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ])
            ->log('User registered via RegisterWidget');
    }

    /**
     * Redirect to intended URL or dashboard after registration.
     *
     * @param User $user
     * @return void
     */
}

/**
 * Get user type options for registration.
 *
 * @return array<string, string>
 */
protected function getUserTypeOptions(): array
{
    $userTypes = config('moderation.user_types', []);
    $options = [];
    
    foreach ($userTypes as $key => $config) {
        $options[$key] = $config['label'] ?? ucfirst($key);
    }
    
    return $options ?: [
        'standard' => 'Standard User',
        'professional' => 'Professional',
    ];
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
        ->schema($this->getFormSchema())
        ->statePath('data')
        ->operation('create');
}

/**
 * Handle form submission with comprehensive error handling and validation.
 *
 * @return void
 * @throws \Illuminate\Validation\ValidationException
 * @throws \RuntimeException
 */
public function submit(): void
{
    try {
        // Validate form data first
        $validatedData = $this->validateForm();
        
        // Log registration attempt with hashed PII for security
        $this->logRegistrationAttempt($validatedData);
        
        // Begin database transaction for data integrity
        $user = \DB::transaction(function () use ($validatedData) {
            // Create user with validated data
            $user = $this->createUser($validatedData);
            
            // Trigger any post-registration events
            $this->afterUserCreated($user);
            
            return $user;
        });
        
        // Log successful registration with user ID
        Log::info('User registered successfully', [
            'user_id' => $user->id,
            'email_hash' => hash('sha256', $user->email),
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
        
        // Send email verification if needed
        if (config('auth.must_verify_email')) {
            $user->sendEmailVerificationNotification();
        }
        
        // Log in the user
        Auth::login($user);
        
        // Redirect to intended URL or dashboard
        $this->redirectAfterRegistration($user);
        
    } catch (\Illuminate\Validation\ValidationException $e) {
        // Re-throw validation exceptions to be handled by Filament
        throw $e;
        
    } catch (\Exception $e) {
        // Log detailed error information
        Log::error('Registration failed: ' . $e->getMessage(), [
            'exception' => $e,
            'trace' => $e->getTraceAsString(),
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
        
        // Show user-friendly error message
        $this->dispatchBrowserEvent('registration-failed', [
            'message' => __('user::auth.registration.failed')
        ]);
        
        // Re-throw with a generic message for the UI
        throw new \RuntimeException(__('user::auth.registration.error_occurred'));
    }
}

/**
 * Validate form data before registration.
 *
 * @return array<string, mixed>
 * @throws \Illuminate\Validation\ValidationException
 */
protected function validateForm(): array
{
    $data = $this->form->getState();
    
    // Hash password securely
    $data['password'] = Hash::make((string) $data['password']);
    
    // Create user with safe data
    $userData = [
        'first_name' => (string) $data['first_name'],
        'last_name' => (string) $data['last_name'],
        'email' => (string) $data['email'],
        'password' => $data['password'],
        'type' => (string) ($data['type'] ?? 'standard'),
        'state' => 'pending',
        'email_verified_at' => null,
    ];
    
    return $userData;
}

/**
 * Log registration attempt with hashed PII for security.
 *
 * @param array<string, mixed> $validatedData
 * @return void
 */
protected function logRegistrationAttempt(array $validatedData): void
{
    Log::info('Registration attempt', [
        'email_hash' => hash('sha256', $validatedData['email']),
        'ip' => request()->ip(),
        'user_agent' => request()->userAgent(),
    ]);
}

/**
 * Create user with validated data.
 *
 * @param array<string, mixed> $validatedData
 * @return User
 */
protected function createUser(array $validatedData): User
{
    return User::create($validatedData);
}

/**
 * Trigger any post-registration events.
 *
 * @param User $user
 * @return void
 */
protected function afterUserCreated(User $user): void
{
    // Activity logging for audit trail
    activity()
        ->causedBy($user)
        ->performedOn($user)
        ->withProperties([
            'type' => $user->type,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ])
        ->log('User registered via RegisterWidget');
}

/**
 * Redirect to intended URL or dashboard after registration.
 *
 * @param User $user
 * @return void
 */
protected function redirectAfterRegistration(User $user): void
{
    // Reset form after successful registration
    $this->form->fill([]);
    
    // Log successful registration
    Log::info('User registration completed', [
        'user_id' => $user->id,
        'type' => $user->type,
        'ip' => request()->ip()
    ]);
    
    // Redirect to dashboard after successful registration
    $this->redirect(route('dashboard'));
}

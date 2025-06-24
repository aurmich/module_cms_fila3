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
                                ->password()
                                ->required()
                                ->rules([Password::default()])
                                ->minLength(8),
                            
                            'password_confirmation' => TextInput::make('password_confirmation')
                                ->password()
                                ->required()
                                ->same('password')
                                ->dehydrated(false),
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
     * Handle user registration with proper validation and security.
     *
     * Implements secure registration process with proper data validation,
     * password hashing, and audit logging.
     *
     * @return void
     */
    public function register(): void
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
        
        $user = User::create($userData);
        
        // Activity logging for audit trail
        activity()
            ->causedBy($user)
            ->performedOn($user)
            ->withProperties([
                'type' => $userData['type'],
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ])
            ->log('User registered via RegisterWidget');
        
        // Reset form after successful registration
        $this->form->fill([]);
        
        Log::info('User registered successfully', [
            'user_id' => $user->id,
            'email' => $user->email,
            'type' => $userData['type'],
        ]);
        
        session()->flash('status', __('Registration completed successfully'));
    }
}

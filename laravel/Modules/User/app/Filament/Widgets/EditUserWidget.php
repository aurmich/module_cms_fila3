<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets;

use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Modules\Xot\Filament\Widgets\XotBaseWidget;
use Modules\User\Models\User;
use Modules\Xot\Datas\XotData;

class EditUserWidget extends XotBaseWidget implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];
    protected int | string | array $columnSpan = 'full';
    public User $record;
    protected static string $view = 'user::filament.widgets.edit-user';

    public function mount(User $record): void
    {
        $this->record = $record;
        $this->form->fill([
            'name' => $record->name,
            'first_name' => $record->first_name,
            'last_name' => $record->last_name,
            'email' => $record->email,
            'lang' => $record->lang,
            'is_active' => $record->is_active,
            'is_otp' => $record->is_otp,
            'profile_photo_path' => $record->profile_photo_path,
            'password_expires_at' => $record->password_expires_at,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema($this->getFormSchema())
            ->statePath('data');
    }

    /**
     * Get the form schema for editing user profile.
     *
     * @return array<string, \Filament\Forms\Components\Component>
     */
    public function getFormSchema(): array
    {
        return [
            'personal_info' => Section::make()
                ->schema([
                    'profile_photo_path' => FileUpload::make('profile_photo_path')
                        ->avatar()
                        ->imageEditor()
                        ->directory('profile-photos')
                        ->visibility('public')
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                        ->maxSize(2048),

                    'name_grid' => Grid::make(2)
                        ->schema([
                            'first_name' => TextInput::make('first_name')
                                ->required()
                                ->maxLength(255),

                            'last_name' => TextInput::make('last_name')
                                ->required()
                                ->maxLength(255),
                        ]),

                    'name' => TextInput::make('name')
                        ->required()
                        ->maxLength(255),

                    'email' => TextInput::make('email')
                        ->email()
                        ->required()
                        ->unique(User::class, 'email', ignoreRecord: true)
                        ->maxLength(255),
                ]),

            'preferences' => Section::make()
                ->schema([
                    'lang' => Select::make('lang')
                        ->options([
                            'it' => __('user::widgets.edit_user.fields.lang.options.it'),
                            'en' => __('user::widgets.edit_user.fields.lang.options.en'),
                            'es' => __('user::widgets.edit_user.fields.lang.options.es'),
                            'fr' => __('user::widgets.edit_user.fields.lang.options.fr'),
                            'de' => __('user::widgets.edit_user.fields.lang.options.de'),
                        ])
                        ->default('it'),
                ]),

            'security' => Section::make()
                ->schema([
                    'password_grid' => Grid::make(2)
                        ->schema([
                            'password' => TextInput::make('password')
                                ->password()
                                ->dehydrated(fn ($state): bool => filled($state))
                                ->rule(Password::default())
                                ->autocomplete('new-password'),

                            'password_confirmation' => TextInput::make('password_confirmation')
                                ->password()
                                ->same('password')
                                ->dehydrated(false)
                                ->autocomplete('new-password'),
                        ]),

                    'security_options' => Grid::make(2)
                        ->schema([
                            'is_otp' => Toggle::make('is_otp'),

                            'password_expires_at' => DateTimePicker::make('password_expires_at')
                                ->native(false)
                                ->displayFormat('d/m/Y H:i'),
                        ]),
                ])
                ->visible(fn (): bool => $this->canEditSecurity()),

            'admin_settings' => Section::make()
                ->schema([
                    'is_active' => Toggle::make('is_active'),
                ])
                ->visible(fn (): bool => $this->canEditAdminSettings()),
        ];
    }

    /**
     * Get form actions.
     *
     * @return array<\Filament\Forms\Components\Actions\Action>
     */
    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->action('save')
                ->color('primary'),

            Action::make('cancel')
                ->action('cancel')
                ->color('gray'),
        ];
    }

    /**
     * Save the form data.
     */
    public function save(): void
    {
        $data = $this->form->getState();

        // Hash password if provided
        if (filled($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        // Update the record
        $this->record->update($data);

        Notification::make()
            ->title(__('user::widgets.edit_user.messages.saved'))
            ->success()
            ->send();

        // Redirect or emit event as needed
        $this->dispatch('user-updated', userId: $this->record->id);
    }

    /**
     * Cancel editing.
     */
    public function cancel(): void
    {
        $this->form->fill([
            'name' => $this->record->name,
            'first_name' => $this->record->first_name,
            'last_name' => $this->record->last_name,
            'email' => $this->record->email,
            'lang' => $this->record->lang,
            'is_active' => $this->record->is_active,
            'is_otp' => $this->record->is_otp,
            'profile_photo_path' => $this->record->profile_photo_path,
            'password_expires_at' => $this->record->password_expires_at,
        ]);

        Notification::make()
            ->title(__('user::widgets.edit_user.messages.cancelled'))
            ->warning()
            ->send();
    }

    /**
     * Check if current user can edit security settings.
     */
    protected function canEditSecurity(): bool
    {
        $currentUser = auth()->user();
        
        // User can edit their own security settings
        if ($currentUser && $currentUser->id === $this->record->id) {
            return true;
        }

        // Admin can edit any user's security settings
        return $currentUser && $currentUser->hasRole('admin');
    }

    /**
     * Check if current user can edit admin settings.
     */
    protected function canEditAdminSettings(): bool
    {
        $currentUser = auth()->user();
        
        // Only admin can edit admin settings
        return $currentUser && $currentUser->hasRole('admin');
    }

    /**
     * Check if current user can edit this record.
     */
    protected function canEdit(): bool
    {
        $currentUser = auth()->user();
        
        // User can edit their own profile
        if ($currentUser && $currentUser->id === $this->record->id) {
            return true;
        }

        // Admin can edit any profile
        return $currentUser && $currentUser->hasRole('admin');
    }
}

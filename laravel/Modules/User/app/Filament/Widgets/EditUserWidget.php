<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets;

use Filament\Forms\Form;
<<<<<<< HEAD
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Filament\Widgets\Widget;
use Illuminate\Http\Request;
use Webmozart\Assert\Assert;
use Modules\Xot\Datas\XotData;
use Livewire\Attributes\Validate;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Modules\Xot\Contracts\UserContract;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Concerns\InteractsWithForms;
use Modules\Xot\Filament\Widgets\XotBaseWidget;
use Illuminate\Support\Facades\Log;

/**
 * EditUserWidget: Widget generico per la modifica dati utente.
 * 
 * Segue il pattern di delegazione del RegistrationWidget:
 * - Raccoglie i dati dal form
 * - Determina dinamicamente la risorsa, il modello e l'action da eseguire
 * - Delega la logica di salvataggio a una UpdateAction specifica del modulo
 * 
 * Il widget è completamente generico e riutilizzabile per qualsiasi tipo di utente.
 */
class EditUserWidget extends XotBaseWidget
{
    public ?array $data = [];
    protected int | string | array $columnSpan = 'full';
    public string $type;
    public string $resource;
    public string $model;
    public string $action;
    public Model $record;
    
    protected static string $view = 'pub_theme::filament.widgets.edit-user';

    public function mount(string $type, ?int $userId = null): void
    {
        $this->type = $type;
        $this->resource = XotData::make()->getUserResourceClassByType($type);
        $this->model = $this->resource::getModel();
        $this->action = Str::of($this->model)->replace('\Models\\', '\Actions\\')->append('\UpdateUserAction')->toString();
        
        $record = $this->getFormModel($userId);
        $data = $this->getFormFill();
        
        $this->form->fill($data);
        $this->form->model($record);
        $this->data = $data;
        $this->record = $record;
    }

    /**
     * Ottiene il modello per il form.
     * Se viene fornito un userId, carica quell'utente, altrimenti usa l'utente autenticato.
     */
    public function getFormModel(?int $userId = null): Model
    {
        if ($userId) {
            $user = $this->model::findOrFail($userId);
            return $user;
        }

        // Se non è specificato un userId, usa l'utente correntemente autenticato
        $currentUser = Auth::user();
        if ($currentUser && $currentUser instanceof $this->model) {
            return $currentUser;
        }

        // Fallback: cerca un utente del tipo corretto associato all'utente autenticato
        if ($currentUser) {
            $user = $this->model::where('user_id', $currentUser->id)->first();
            if ($user) {
                return $user;
            }
        }

        // Ultimo fallback: nuovo modello
        return app($this->model);
    }

    /**
     * Ottiene i dati per il riempimento del form.
     */
    public function getFormFill(): array
    {
        $model = $this->record ?? $this->getFormModel();
        
        // Se il modello ha un ID, significa che è stato trovato nel database
        if ($model->exists) {
            try {
                return $model->toArray();
            } catch (\Exception $e) {
                // Se toArray() fallisce (problemi con enum), usa getAttributes()
                Log::warning("Errore in toArray() per modello {$this->model}: " . $e->getMessage());
                $attributes = $model->getAttributes();
                
                // Gestisci specificamente gli enum se presenti
                if (isset($attributes['type']) && $model->type instanceof \BackedEnum) {
                    $attributes['type'] = $model->type->value;
                }
                
                return $attributes;
            }
        }
        
        // Se è un nuovo modello, restituisci solo i campi fillable con valori null
        $fillable = $model->getFillable();
        $appends = $model->getAppends();
        $fields = array_merge($fillable, $appends);
        
        return array_fill_keys($fields, null);
    }

    /**
     * Ottiene lo schema del form dalla resource.
     */
    public function getFormSchema(): array
    {
        return $this->resource::getFormSchemaWidget();
    }

    /**
     * Gestisce il salvataggio delle modifiche delegando all'action specifica.
     * 
     * @see https://filamentphp.com/docs/3.x/forms/adding-a-form-to-a-livewire-component
     */
    public function updateUser(): \Illuminate\Http\RedirectResponse|\Livewire\Features\SupportRedirects\Redirector
    {
        $data = $this->form->getState();
        $record = $this->record;
       
        // Delega l'aggiornamento all'action specifica
        $user = app($this->action)->execute($record, $data);
        
        // Notifica successo
        session()->flash('message', __('user::profile.update_success'));
        
        // Aggiorna il form con i nuovi dati
        $this->form->fill($this->getFormFill());
        
        return redirect()->back();
    }

    /**
     * Controlla se l'utente può modificare il record corrente.
     */
    public function canEdit(): bool
    {
        $currentUser = Auth::user();
        
        // L'utente può modificare solo il proprio profilo
        return $currentUser && (
            $currentUser->id === $this->record->id ||
            $currentUser->id === $this->record->user_id ?? null
        );
    }
} 
=======
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
>>>>>>> a3f7230 (.)

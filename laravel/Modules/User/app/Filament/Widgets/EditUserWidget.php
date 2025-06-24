<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets;

use Filament\Forms\Form;
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
<<<<<<< HEAD
 *
 * @property-read string $type
 * @property-read string $resource
 * @property-read string $model
 * @property-read string $action
 * @property-read Model $record
 * @property array|null $data
 */
class EditUserWidget extends XotBaseWidget
{
    /** @var array<string, mixed>|null */
    public ?array $data = [];
    
    /** @var int|string|array<string, mixed> */
    protected int | string | array $columnSpan = 'full';
    
=======
 */
class EditUserWidget extends XotBaseWidget
{
    public ?array $data = [];
    protected int | string | array $columnSpan = 'full';
>>>>>>> 999c8e14 (✨ (User Module): introduce EditUserWidget for user data modification)
    public string $type;
    public string $resource;
    public string $model;
    public string $action;
    public Model $record;
    
    protected static string $view = 'pub_theme::filament.widgets.edit-user';

<<<<<<< HEAD
    /**
     * Initialize the widget with user type and optional user ID.
     *
     * @param string $type
     * @param int|null $userId
     * @return void
     */
=======
>>>>>>> 999c8e14 (✨ (User Module): introduce EditUserWidget for user data modification)
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
<<<<<<< HEAD
     *
     * @param int|null $userId
     * @return Model
=======
>>>>>>> 999c8e14 (✨ (User Module): introduce EditUserWidget for user data modification)
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
<<<<<<< HEAD
     *
     * @return array<string, mixed>
=======
>>>>>>> 999c8e14 (✨ (User Module): introduce EditUserWidget for user data modification)
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
<<<<<<< HEAD
     *
     * @return array<string, mixed>
=======
>>>>>>> 999c8e14 (✨ (User Module): introduce EditUserWidget for user data modification)
     */
    public function getFormSchema(): array
    {
        return $this->resource::getFormSchemaWidget();
    }

    /**
     * Gestisce il salvataggio delle modifiche delegando all'action specifica.
     * 
     * @see https://filamentphp.com/docs/3.x/forms/adding-a-form-to-a-livewire-component
<<<<<<< HEAD
     *
     * @return \Illuminate\Http\RedirectResponse|\Livewire\Features\SupportRedirects\Redirector
=======
>>>>>>> 999c8e14 (✨ (User Module): introduce EditUserWidget for user data modification)
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
<<<<<<< HEAD
     *
     * @return bool
=======
>>>>>>> 999c8e14 (✨ (User Module): introduce EditUserWidget for user data modification)
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
<<<<<<< HEAD
}
=======
} 
>>>>>>> 999c8e14 (✨ (User Module): introduce EditUserWidget for user data modification)

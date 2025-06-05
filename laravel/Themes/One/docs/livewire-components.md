# Componenti Livewire

## Profile Management

### 1. Profile Edit Component

```php
namespace Themes\One\Http\Livewire\Profile;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class Edit extends Component
{
    public ?User $user;
    public string $delete_confirm_password = '';

    protected $rules = [
        'delete_confirm_password' => 'required|string',
    ];

    public function mount()
    {
        $this->user = auth()->user();
    }

    /**
     * Gestisce l'eliminazione dell'account utente
     */
    public function destroy(): \Illuminate\Http\RedirectResponse
    {
        if (!$this->user || !Hash::check($this->delete_confirm_password, $this->user->password)) {
            $this->dispatch('toast', 
                message: 'Password non corretta', 
                data: [
                    'position' => 'top-right',
                    'type' => 'danger'
                ]
            );
            $this->reset(['delete_confirm_password']);
            return;
        }

        $user = auth()->user();
        if (!$user) {
            return redirect('/');
        }

        Auth::logout();
        $user->delete();

        return redirect('/');
    }

    public function render()
    {
        return view('theme::pages.profile.edit');
    }
}
```

### 2. View Template

```blade
{{-- resources/views/pages/profile/edit.blade.php --}}
<div>
    <x-slot name="header">
        <h2>{{ __('Profile') }}</h2>
    </x-slot>

    <div class="space-y-6">
        @include('theme::profile.partials.update-profile-information-form')
        @include('theme::profile.partials.update-password-form')
        @include('theme::profile.partials.delete-user-form')
    </div>
</div>
```

### 3. Delete User Form Partial

```blade
{{-- resources/views/profile/partials/delete-user-form.blade.php --}}
<section class="space-y-6">
    <header>
        <h2>{{ __('Delete Account') }}</h2>
        <p>{{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}</p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >
        {{ __('Delete Account') }}
    </x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form wire:submit="destroy" class="p-6">
            <h2>{{ __('Are you sure you want to delete your account?') }}</h2>
            <p>{{ __('Please enter your password to confirm you would like to permanently delete your account.') }}</p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    wire:model="delete_confirm_password"
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-3">
                    {{ __('Delete Account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
```

## Funzionalità

### 1. Eliminazione Account
- Verifica della password dell'utente
- Gestione degli errori con toast notifications
- Logout automatico dopo l'eliminazione
- Reindirizzamento alla homepage

### 2. Sicurezza
- Verifica dell'autenticazione dell'utente
- Hashing della password
- Protezione CSRF automatica di Livewire
- Validazione dei dati in input

### 3. UX/UI
- Modal di conferma per azioni distruttive
- Feedback immediato all'utente
- Form di conferma password
- Pulsanti di cancellazione e conferma

## Eventi

### 1. Toast Notifications
```php
$this->dispatch('toast', [
    'message' => 'Messaggio',
    'data' => [
        'position' => 'top-right',
        'type' => 'danger|success|info'
    ]
]);
```

### 2. Modal Events
```js
$dispatch('open-modal', 'confirm-user-deletion')
$dispatch('close')
```

## Best Practices

### 1. Sicurezza
- Validare sempre l'input dell'utente
- Verificare l'autenticazione
- Utilizzare CSRF protection
- Implementare conferme per azioni distruttive

### 2. UX
- Fornire feedback immediato
- Confermare azioni distruttive
- Mantenere uno stato consistente
- Gestire gli errori in modo user-friendly

### 3. Manutenibilità
- Separare la logica dalla presentazione
- Utilizzare componenti riutilizzabili
- Documentare le funzionalità
- Seguire le convenzioni di naming

### 4. Performance
- Minimizzare le richieste al server
- Utilizzare la validazione lato client
- Implementare il lazy loading
- Ottimizzare le query al database

## Testing

### 1. Feature Tests
```php
namespace Tests\Feature\Profile;

class DeleteUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_delete_their_account()
    {
        $user = User::factory()->create();
        
        Livewire::actingAs($user)
            ->test(Edit::class)
            ->set('delete_confirm_password', 'password')
            ->call('destroy')
            ->assertRedirect('/');

        $this->assertNull($user->fresh());
    }

    /** @test */
    public function correct_password_must_be_provided_before_account_can_be_deleted()
    {
        $user = User::factory()->create();
        
        Livewire::actingAs($user)
            ->test(Edit::class)
            ->set('delete_confirm_password', 'wrong-password')
            ->call('destroy');

        $this->assertNotNull($user->fresh());
    }
}
```

## Componenti Volt

### 1. Struttura Base
```blade
@volt('nome-componente')
<div>
    <!-- Contenuto del componente -->
</div>
@endvolt
```

### 2. Regole Importanti
- Un componente Volt può avere UN SOLO elemento root
- L'elemento root deve essere un singolo div o altro elemento HTML
- Non è possibile avere più elementi root allo stesso livello
- La logica PHP deve essere definita prima del template

### 3. Esempio Corretto
```blade
<?php
// Logica del componente
$nome = 'Mario';
?>

@volt('esempio')
<div>
    <h1>Ciao {{ $nome }}</h1>
    <p>Questo è un esempio corretto</p>
</div>
@endvolt
```

### 4. Esempio Errato
```blade
@volt('esempio-errato')
<div>Primo elemento</div>
<div>Secondo elemento</div> <!-- ERRORE: Più elementi root -->
@endvolt
```

### 5. Best Practices
- Mantenere la logica PHP separata dal template
- Utilizzare un singolo elemento root
- Organizzare il contenuto in modo gerarchico
- Evitare elementi root multipli

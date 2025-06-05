# Best Practices

## Architettura

### Struttura dei Moduli
- Seguire la struttura standard
- Mantenere le cartelle in minuscolo
- Organizzare il codice per feature

### Folio
- Usare nomi descrittivi per le pagine
- Organizzare le pagine in sottocartelle logiche
- Mantenere la struttura piatta quando possibile
- Utilizzare middleware appropriati
- Documentare le dipendenze

### Volt
- Creare componenti atomici
- Separare la logica dalla presentazione
- Documentare gli stati e i metodi
- Utilizzare props per la configurazione
- Mantenere i componenti riutilizzabili

## Sviluppo

### Codice
- Seguire PSR-12
- Utilizzare type hinting
- Documentare le funzioni
- Mantenere le funzioni brevi
- Evitare duplicazione

### Testing
- Scrivere test per ogni feature
- Utilizzare test automatizzati
- Mantenere alta copertura
- Testare edge cases

### Performance
- Ottimizzare le query
- Utilizzare caching
- Minimizzare le dipendenze
- Monitorare le performance

## Sicurezza

### Autenticazione
- Utilizzare middleware appropriati
- Validare gli input
- Sanitizzare i dati
- Proteggere le rotte

### Autorizzazione
- Implementare RBAC
- Verificare i permessi
- Loggare le azioni
- Monitorare gli accessi

## Documentazione

### Codice
- Commentare il codice
- Documentare le API
- Mantenere aggiornati i README
- Seguire le convenzioni

### Utente
- Fornire guide chiare
- Documentare le feature
- Mantenere esempi aggiornati
- Supportare multilingua

## Esempi

### Pagina Folio
```php
// resources/views/pages/auth/login.blade.php
<?php

use function Livewire\Volt\{state, mount};

state([
    'email' => '',
    'password' => '',
]);

$login = function() {
    // logica di login
};

?>

<div>
    <x-auth.login-form />
</div>
```

### Componente Volt
```php
// resources/views/components/auth/login-form.blade.php
<?php

use function Livewire\Volt\{state, mount};

state([
    'email' => '',
    'password' => '',
    'remember' => false,
]);

$submit = function() {
    // logica di submit
};

?>

<form wire:submit="submit">
    <!-- campi del form -->
</form>
```

### Middleware
```php
// app/Http/Middleware/Authenticate.php
class Authenticate
{
    public function handle($request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
```

### Test
```php
// tests/Feature/Auth/LoginTest.php
class LoginTest extends TestCase
{
    public function test_user_can_login()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }
}
```

# Best Practices per Laraxot

## Riferimenti al modello User

Una pratica fondamentale in Laraxot è **non fare mai riferimento diretto** alla classe specifica di implementazione dell'utente (`\Modules\User\Models\User`), poiché il modello utente effettivamente utilizzato viene configurato nei file di configurazione del sistema.

### ❌ Pratica scorretta

```php
/**
 * @var \Modules\User\Models\User $user
 */
public function handle($user) {
    // Codice che usa $user
}
```

### ✓ Pratica corretta

```php
use Modules\Xot\Contracts\UserContract;

/**
 * @var UserContract $user
 */
public function handle($user) {
    // Codice che usa $user
}
```

### Motivi per utilizzare UserContract

1. **Configurabilità**: Il modello User effettivo può cambiare in base alla configurazione.
2. **Disaccoppiamento**: Riduce le dipendenze verso implementazioni specifiche.
3. **Testabilità**: Facilita il testing con implementazioni mock dell'interfaccia.
4. **Flessibilità**: Consente di estendere o cambiare l'implementazione senza impattare il codice esistente.

### Come ottenere la classe User corretta

Se è necessario ottenere programmaticamente la classe User configurata:

```php
use Modules\Xot\Datas\XotData;

// Ottenere la classe User configurata
$userClass = XotData::make()->getUserClass();

// Creare un'istanza
$user = new $userClass();
```

### Tipizzazione nei parametri di metodo

Quando si tipizzano i parametri di un metodo:

```php
use Modules\Xot\Contracts\UserContract;

// Corretto
public function process(UserContract $user) {
    // Codice
}

// Errato
public function process(\Modules\User\Models\User $user) {
    // Codice
}
``` 
## Collegamenti tra versioni di best-practices.md
* [best-practices.md](../../../../docs/tecnico/filament/best-practices.md)
* [best-practices.md](laraxot/best-practices.md)
* [best-practices.md](../../UI/docs/best-practices.md)
* [best-practices.md](../../../Themes/One/docs/best-practices.md)


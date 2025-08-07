# Stati e Transizioni

## Struttura delle Directory
Gli stati e le transizioni devono essere organizzati secondo la seguente struttura:

```
app/States/
  ├── User/
  │   ├── Transitions/
  │   │   ├── PendingToActive.php
  │   │   ├── PendingToRejected.php
  │   │   └── ...
  │   ├── UserState.php
  │   ├── Pending.php
  │   ├── Active.php
  │   └── ...
```

## Convenzioni di Nomenclatura
- Le classi di stato devono essere nominate in modo descrittivo (es. `Pending`, `Active`, `Rejected`)
- Le classi di transizione devono seguire il pattern `FromStateToState` (es. `PendingToActive`)
- Tutte le classi devono essere nel namespace corretto: `Modules\SaluteOra\States\User`

## Implementazione delle Transizioni
Le classi di transizione devono:
1. Estendere la classe base `Transition` di Spatie
2. Implementare il costruttore che accetta lo stato di partenza
3. Implementare il metodo `canTransition()` per la logica di validazione
4. Implementare il metodo `handle()` per la logica di transizione

## Best Practices
- Utilizzare il trait `HasStates` nel modello
- Definire le transizioni consentite nel metodo `config()` della classe di stato
- Mantenere la logica di transizione semplice e atomica
- Documentare le condizioni di transizione nel metodo `canTransition()`

## Collegamenti
- [Documentazione Spatie Model States](https://spatie.be/docs/laravel-model-states)
- [Regole Generali Stati](../Xot/docs/STATES.md) 

## Modal di Conferma per Transizioni di Stato

### Implementazione del Modal
Per implementare un modal di conferma con textarea per le transizioni di stato, seguire questi passaggi:

1. **Creazione del Componente Modal**
```php
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Modal;

Modal::make('confirmStateTransition')
    ->title('Conferma Cambio Stato')
    ->description('Inserisci una nota per giustificare il cambio di stato')
    ->form([
        Textarea::make('note')
            ->label('Nota')
            ->required()
            ->minLength(10)
            ->maxLength(500)
    ])
    ->action(function (array $data) {
        // Logica di transizione
    })
    ->cancelAction()
    ->closeButton()
```

2. **Integrazione con la Transizione**
```php
use Filament\Actions\Action;

Action::make('changeState')
    ->modal('confirmStateTransition')
    ->action(function (array $data) {
        $this->state->transitionTo(NewState::class, [
            'note' => $data['note']
        ]);
    })
```

### Best Practices per il Modal
- Mantenere il testo della nota obbligatorio e con una lunghezza minima
- Fornire un feedback chiaro all'utente dopo la transizione
- Validare la nota prima di procedere con la transizione
- Mantenere un log delle transizioni con le relative note

### Esempio di Implementazione Completa
```php
use Filament\Resources\Resource;
use Filament\Actions\Action;

class YourResource extends Resource
{
    public static function getActions(): array
    {
        return [
            Action::make('changeState')
                ->modal('confirmStateTransition')
                ->form([
                    Textarea::make('note')
                        ->label('Nota')
                        ->required()
                        ->minLength(10)
                        ->maxLength(500)
                ])
                ->action(function (array $data) {
                    $this->state->transitionTo(NewState::class, [
                        'note' => $data['note']
                    ]);
                    
                    Notification::make()
                        ->title('Stato aggiornato con successo')
                        ->success()
                        ->send();
                })
        ];
    }
}
```

### Note Importanti
- Il modal deve essere utilizzato per tutte le transizioni di stato che richiedono una giustificazione
- La nota deve essere salvata insieme alla transizione per tracciabilità
- Considerare l'implementazione di un sistema di notifica per informare gli utenti interessati
- Mantenere un log delle transizioni per audit e debugging

## Gestione dei Parametri nelle Transizioni

### Costruttore delle Transizioni
Quando si implementa una transizione di stato, è importante gestire correttamente i parametri del costruttore:

1. **Parametri Obbligatori**
   - Il primo parametro deve essere sempre il modello (`User $user`)
   - I parametri aggiuntivi (es. `string $message`) devono essere opzionali o gestiti tramite array di parametri

2. **Implementazione Corretta**
```php
// CORRETTO
class ActiveToSuspended extends Transition
{
    public User $user;
    public ?string $message;

    public function __construct(User $user, ?string $message = null) 
    {
        $this->user = $user;
        $this->message = $message;
    }
}

// ERRATO
class ActiveToSuspended extends Transition
{
    public User $user;
    public string $message;

    public function __construct(User $user, string $message) // Richiede sempre message
    {
        $this->user = $user;
        $this->message = $message;
    }
}
```

### Best Practices per i Parametri
- Rendere opzionali i parametri aggiuntivi usando `?` o valori di default
- Utilizzare array di parametri per transizioni complesse
- Documentare sempre i parametri richiesti e opzionali
- Mantenere la retrocompatibilità quando si aggiungono nuovi parametri

### Gestione degli Errori
- Implementare validazione dei parametri nel costruttore
- Fornire messaggi di errore chiari quando i parametri non sono validi
- Loggare le transizioni fallite per debugging

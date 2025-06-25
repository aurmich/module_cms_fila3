# Workflow di Integrazione Utenti - SaluteOra

## Introduzione

Il workflow di integrazione è un processo che permette di gestire utenti che necessitano di fornire informazioni aggiuntive dopo la registrazione iniziale. Questo documento descrive il nuovo flusso che include lo stato `IntegrationCompleted`.

## Stati del Workflow di Integrazione

### 1. IntegrationRequested
**Stato**: `integration_requested`  
**Colore**: `info`  
**Icona**: `heroicon-o-document-text`

- **Descrizione**: L'utente ha completato la registrazione ma sono richieste ulteriori informazioni
- **Trigger**: Mancanza di dati essenziali o necessità di verifica aggiuntiva
- **Azioni disponibili**: Fornire dati mancanti, tornare in pending

### 2. IntegrationCompleted (NUOVO)
**Stato**: `integration_completed`  
**Colore**: `success`  
**Icona**: `heroicon-o-check-circle`

- **Descrizione**: L'utente ha fornito tutte le informazioni richieste
- **Trigger**: Completamento dell'integrazione dati da parte dell'utente
- **Azioni disponibili**: Approvazione da parte dell'amministratore

## Flusso di Transizioni

### Flusso Completo
```
Pending
├── → Active (approvazione diretta)
├── → Rejected (respinto)
└── → IntegrationRequested (richiesta integrazione)
    ├── → IntegrationCompleted (dati completati dall'utente)
    │   ├── → Active (approvazione amministratore)
    │   ├── → Rejected (respinto dopo verifica)
    │   └── → IntegrationRequested (servono ulteriori dati)
    ├── → Active (approvazione diretta)
    └── → Rejected (respinto)
```

### Transizioni da IntegrationCompleted

Lo stato `IntegrationCompleted` può transitare verso tre stati diversi in base alla valutazione dell'amministratore:

#### 1. IntegrationCompleted → Active
**Scenario**: Approvazione normale
- Tutti i dati forniti sono corretti e sufficienti
- I documenti sono validi e autentici
- L'utente risponde a tutti i criteri richiesti
- L'amministratore approva definitivamente

#### 2. IntegrationCompleted → Rejected
**Scenario**: Respingimento dopo verifica
- I documenti forniti sono falsi, scaduti o non validi
- I dati inseriti sono risultati non veritieri
- L'utente non risponde ai criteri di ammissibilità
- Violazione di policy aziendali o normative
- Decisione amministrativa negativa per altri motivi

#### 3. IntegrationCompleted → IntegrationRequested
**Scenario**: Richiesta di ulteriori dati
- Durante la verifica sono emerse necessità aggiuntive
- Servono documenti supplementari non previsti inizialmente
- Alcuni dati forniti necessitano correzioni o chiarimenti
- Modifiche normative che richiedono nuove informazioni
- Aggiornamento dati scaduti o obsoleti

### Transizioni Specifiche del Workflow

#### 1. IntegrationRequestedToIntegrationCompleted
```php
namespace Modules\SaluteOra\States\User\Transitions;

class IntegrationRequestedToIntegrationCompleted extends Transition
{
    public function handle(): User
    {
        $this->user->state = new IntegrationCompleted($this->user);
        $this->user->save();
        return $this->user;
    }
}
```

**Quando utilizzare**: Quando l'utente ha fornito tutti i dati richiesti.

#### 2. IntegrationCompletedToActive
```php
namespace Modules\SaluteOra\States\User\Transitions;

class IntegrationCompletedToActive extends Transition
{
    public function handle(): User
    {
        $this->user->state = new Active($this->user);
        $this->user->save();
        return $this->user;
    }
}
```

**Quando utilizzare**: Quando l'amministratore approva l'utente dopo verifica positiva.

#### 3. IntegrationCompletedToRejected
```php
namespace Modules\SaluteOra\States\User\Transitions;

class IntegrationCompletedToRejected extends Transition
{
    public function handle(): User
    {
        $this->user->state = new Rejected($this->user);
        $this->user->save();
        return $this->user;
    }
}
```

**Quando utilizzare**: Quando l'amministratore respinge l'utente dopo aver verificato i dati completati (documenti falsi, criteri non rispettati, ecc.).

#### 4. IntegrationCompletedToIntegrationRequested
```php
namespace Modules\SaluteOra\States\User\Transitions;

class IntegrationCompletedToIntegrationRequested extends Transition
{
    public function handle(): User
    {
        $this->user->state = new IntegrationRequested($this->user);
        $this->user->save();
        return $this->user;
    }
}
```

**Quando utilizzare**: Quando durante la verifica si scopre che servono ulteriori documenti o correzioni.

### Esempi Pratici

#### Scenario Dottore - Approvazione
1. Dottore completa integrazione → `IntegrationCompleted`
2. Amministratore verifica albo medico e specializzazioni → Tutto OK
3. Transizione a `Active` → Dottore può iniziare a operare

#### Scenario Dottore - Respingimento
1. Dottore completa integrazione → `IntegrationCompleted`
2. Amministratore scopre che l'abilitazione è sospesa → Non idoneo
3. Transizione a `Rejected` → Account bloccato definitivamente

#### Scenario Dottore - Ulteriori Dati
1. Dottore completa integrazione → `IntegrationCompleted`
2. Amministratore richiede certificato aggiornato di specializzazione
3. Transizione a `IntegrationRequested` → Dottore deve fornire nuovo documento

#### Scenario Paziente - Approvazione
1. Paziente carica documenti ISEE → `IntegrationCompleted`
2. Amministratore verifica validità → Documenti validi
3. Transizione a `Active` → Paziente può prenotare visite

#### Scenario Paziente - Respingimento  
1. Paziente carica documenti ISEE → `IntegrationCompleted`
2. Amministratore scopre documenti falsificati
3. Transizione a `Rejected` → Account sospeso per frode

#### Scenario Paziente - Ulteriori Dati
1. Paziente carica documenti ISEE → `IntegrationCompleted`
2. Documenti scaduti, serve versione aggiornata
3. Transizione a `IntegrationRequested` → Richiesta nuovo upload

## Scenari di Utilizzo

### Scenario 1: Registrazione Dottore
1. Il dottore si registra con dati minimi
2. Il sistema lo mette in stato `Pending`
3. L'amministratore rileva dati mancanti → transizione a `IntegrationRequested`
4. Il dottore completa i dati → transizione a `IntegrationCompleted`
5. L'amministratore verifica e approva → transizione a `Active`

### Scenario 2: Registrazione Paziente
1. Il paziente si registra con email e password
2. Il sistema lo mette in stato `Pending`
3. Servono documenti aggiuntivi → transizione a `IntegrationRequested`
4. Il paziente carica i documenti → transizione a `IntegrationCompleted`
5. L'amministratore verifica → transizione a `Active`

## Implementazione

### Configurazione Stati in UserState.php
```php
public static function config(): StateConfig
{
    return parent::config()
        // IntegrationRequested transitions
        ->allowTransition(IntegrationRequested::class, IntegrationCompleted::class, 
            Transitions\IntegrationRequestedToIntegrationCompleted::class)
        
        // IntegrationCompleted transitions
        ->allowTransition(IntegrationCompleted::class, Active::class, 
            Transitions\IntegrationCompletedToActive::class)
        
        // Register states
        ->registerState(IntegrationCompleted::class);
}
```

### Utilizzo nelle Azioni
```php
// Utente completa l'integrazione
if ($user->state instanceof IntegrationRequested) {
    $user->state->transitionTo(IntegrationCompleted::class);
}

// Amministratore approva
if ($user->state instanceof IntegrationCompleted) {
    $user->state->transitionTo(Active::class);
}
```

## Controlli e Validazioni

### Metodi di Supporto (da implementare nel modello User)
```php
/**
 * Verifica se l'utente ha completato l'integrazione
 */
public function hasCompletedIntegration(): bool
{
    // Logica per verificare che tutti i dati richiesti siano presenti
    return $this->hasRequiredDocuments() && 
           $this->hasValidContactInfo() && 
           $this->hasRequiredProfile();
}

/**
 * Restituisce i dati mancanti per l'integrazione
 */
public function getMissingIntegrationData(): array
{
    $missing = [];
    
    if (!$this->hasRequiredDocuments()) {
        $missing[] = 'documents';
    }
    
    if (!$this->hasValidContactInfo()) {
        $missing[] = 'contact_info';
    }
    
    // Altri controlli...
    
    return $missing;
}
```

## Best Practices

### 1. Notifiche
- Inviare notifica quando l'utente entra in `IntegrationRequested`
- Notificare l'amministratore quando l'utente raggiunge `IntegrationCompleted`
- Confermare all'utente quando viene attivato

### 2. UI/UX
- Mostrare chiaramente cosa manca per completare l'integrazione
- Fornire un'interfaccia intuitiva per il caricamento dati
- Indicare lo stato corrente del processo

### 3. Sicurezza
- Validare tutti i dati forniti durante l'integrazione
- Verificare i permessi prima di ogni transizione
- Mantenere un audit trail delle transizioni

## Monitoraggio

### Metriche da Tracciare
- Numero di utenti in stato `IntegrationRequested`
- Tempo medio per completare l'integrazione
- Tasso di conversione da `IntegrationRequested` a `Active`
- Utenti bloccati in `IntegrationCompleted`

### Query Utili
```sql
-- Utenti che necessitano integrazione
SELECT * FROM users WHERE state = 'Modules\\SaluteOra\\States\\User\\IntegrationRequested';

-- Utenti che hanno completato l'integrazione
SELECT * FROM users WHERE state = 'Modules\\SaluteOra\\States\\User\\IntegrationCompleted';

-- Statistiche per stato
SELECT state, COUNT(*) as count 
FROM users 
WHERE state LIKE '%Integration%'
GROUP BY state;
```

## Troubleshooting

### Problemi Comuni

1. **Utente bloccato in IntegrationRequested**
   - Verificare quali dati mancano
   - Controllare che l'interfaccia sia accessibile
   - Verificare notifiche inviate

2. **Transizione fallisce**
   - Controllare la configurazione degli stati
   - Verificare che le classi di transizione esistano
   - Controllare i log per errori di validazione

3. **Dati non salvati**
   - Verificare la validazione del modello
   - Controllare i permessi di scrittura
   - Verificare che i campi siano fillable

## Link Correlati

- [Documentazione Stati](./states.md)
- [Best Practices Stati](./state-best-practices.md)
- [Modello User](./user.md)

---

**Aggiornato**: Dicembre 2024  
**Versione**: 1.0  
**Autore**: Sistema di documentazione SaluteOra 
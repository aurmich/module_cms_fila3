# Clean Code Rules - FormBuilder Module

## Data: 2025-07-29

## Panoramica

Questo documento definisce le regole di clean code specifiche per il modulo FormBuilder, con particolare attenzione ai commenti e alla qualità del codice.

## Regole sui Commenti

### 🚫 Commenti VIETATI

#### Commenti Ovvi
```php
// ❌ MAI fare questo
$cat = new Cat(); // È un gatto
$user->getName(); // Ottiene il nome dell'utente
return true; // Ritorna true
$form->save(); // Salva il form
```

#### Commenti che Ripetono il Codice
```php
// ❌ MAI fare questo
// Incrementa il contatore
$counter++;

// Crea un nuovo form
$form = new Form();

// Imposta il titolo
$form->setTitle($title);
```

#### Commenti Inutili o Rumore
```php
// ❌ MAI fare questo
// TODO: Implementare
// FIXME: Questo non funziona
// Codice scritto da Mario Rossi il 15/03/2023
// Fine del metodo
```

### ✅ Commenti UTILI

#### Spiegano il PERCHÉ
```php
// ✅ CORRETTO - Spiega la motivazione
// Timeout di 30 secondi necessario per evitare deadlock con API Zeus
$timeout = 30;

// ✅ CORRETTO - Spiega il contesto business
// Il form deve essere validato prima del salvataggio per conformità GDPR
if (!$form->isValid()) {
    throw new ValidationException();
}
```

#### Spiegano Logica Complessa
```php
// ✅ CORRETTO - Algoritmo non ovvio
// Algoritmo di hash personalizzato per compatibilità con Zeus Bolt
$hash = md5($form->getId() . $form->getCreatedAt()->timestamp);

// ✅ CORRETTO - Logica business complessa
// Calcola il punteggio basato su algoritmo proprietario:
// (risposte_corrette * 10) + (tempo_rimasto / 60) - penalità_errori
$score = ($correctAnswers * 10) + ($timeLeft / 60) - $errorPenalty;
```

#### Avvertimenti Importanti
```php
// ✅ CORRETTO - Avverte di side effects
// ATTENZIONE: Questo metodo modifica lo stato globale del form
$this->resetFormState();

// ✅ CORRETTO - Avverte di comportamenti non ovvi
// NOTA: Il salvataggio è asincrono, usare callback per conferma
$form->saveAsync($callback);
```

## Principi Fondamentali

### 1. Codice Auto-Documentante
```php
// ❌ ERRATO
$d = 30; // giorni

// ✅ CORRETTO
$expirationDaysFromNow = 30;
```

### 2. Nomi Descrittivi
```php
// ❌ ERRATO
function calc($f, $u) {
    // Calcola il punteggio del form per l'utente
    return $f->getScore() * $u->getMultiplier();
}

// ✅ CORRETTO
function calculateFormScoreForUser(Form $form, User $user): int {
    return $form->getScore() * $user->getMultiplier();
}
```

### 3. Metodi Piccoli e Focalizzati
```php
// ❌ ERRATO - Metodo che fa troppe cose
function processForm($form) {
    // Valida il form
    // Salva nel database
    // Invia email
    // Aggiorna statistiche
    // Pulisce cache
}

// ✅ CORRETTO - Metodi specifici
function validateForm(Form $form): bool { }
function saveForm(Form $form): void { }
function sendFormNotification(Form $form): void { }
function updateFormStatistics(Form $form): void { }
function clearFormCache(Form $form): void { }
```

## Regole Specifiche FormBuilder

### 1. Documentazione PHPDoc
```php
/**
 * Processa la risposta del form applicando le regole di validazione Zeus.
 *
 * @param FormResponse $response La risposta da processare
 * @param array<string, mixed> $validationRules Regole di validazione specifiche
 * @return ProcessedResponse Il risultato processato con score e validazione
 * 
 * @throws ValidationException Se la risposta non supera la validazione
 * @throws ProcessingException Se si verifica un errore durante il processing
 */
public function processFormResponse(
    FormResponse $response, 
    array $validationRules
): ProcessedResponse {
    // Implementazione...
}
```

### 2. Costanti Descrittive
```php
// ❌ ERRATO
if ($status === 1) { }

// ✅ CORRETTO
class FormStatus {
    public const DRAFT = 'draft';
    public const PUBLISHED = 'published';
    public const ARCHIVED = 'archived';
}

if ($form->getStatus() === FormStatus::PUBLISHED) { }
```

### 3. Gestione Errori Esplicita
```php
// ❌ ERRATO
try {
    $form->save();
} catch (Exception $e) {
    // Errore generico
}

// ✅ CORRETTO
try {
    $form->save();
} catch (ValidationException $e) {
    $this->handleValidationError($e, $form);
} catch (DatabaseException $e) {
    $this->handleDatabaseError($e, $form);
} catch (Exception $e) {
    $this->handleUnexpectedError($e, $form);
}
```

## Anti-Pattern da Evitare

### 1. Commenti Scusa
```php
// ❌ MAI fare questo
// Questo codice è brutto ma funziona
// Quick fix, da sistemare dopo
// Non so perché funziona ma funziona
// Codice legacy, non toccare
```

### 2. Codice Commentato
```php
// ❌ MAI fare questo
$form->save();
// $form->validate(); // Commentato perché non serve più
// $this->sendEmail($form); // TODO: Riabilitare dopo
```

### 3. Commenti Obsoleti
```php
// ❌ MAI fare questo
// Questo metodo usa MySQL (ora usa PostgreSQL)
// Compatibile con PHP 7.4 (ora richiede PHP 8.2+)
// Integrazione con Zeus v1 (ora v3)
```

## Checklist Clean Code

### Pre-Commit
- [ ] Nessun commento ovvio o ridondante
- [ ] Nomi di variabili e metodi auto-esplicativi
- [ ] Metodi piccoli e focalizzati (max 20 righe)
- [ ] Nessun codice commentato
- [ ] PHPDoc completi per metodi pubblici
- [ ] Gestione errori specifica

### Code Review
- [ ] Il codice si spiega da solo?
- [ ] I commenti aggiungono valore?
- [ ] Le funzioni fanno una sola cosa?
- [ ] I nomi sono descrittivi?
- [ ] La logica è semplice da seguire?

## Strumenti di Validazione

### PHPStan
```bash
# Validazione statica livello 9+
./vendor/bin/phpstan analyze Modules/FormBuilder --level=9
```

### PHP CS Fixer
```bash
# Controllo standard di codice
./vendor/bin/php-cs-fixer fix Modules/FormBuilder --dry-run
```

### Pint
```bash
# Laravel coding standards
./vendor/bin/pint Modules/FormBuilder --test
```

## Filosofia del Modulo

### Principi Guida
1. **Semplicità**: Il codice più semplice è il migliore
2. **Chiarezza**: Preferire la chiarezza alla brevità
3. **Consistenza**: Seguire sempre gli stessi pattern
4. **Manutenibilità**: Scrivere per chi leggerà il codice domani

### Zen del FormBuilder
- "Un form ben scritto non ha bisogno di commenti"
- "Il codice racconta una storia, i commenti spiegano il contesto"
- "Se devi commentare cosa fa il codice, riscrivi il codice"
- "Un commento ovvio è peggio del silenzio"

## Esempi Pratici FormBuilder

### Form Validation
```php
// ❌ ERRATO
function validate($form) {
    // Controlla se il form è valido
    if ($form->fields) {
        // Cicla sui campi
        foreach ($form->fields as $field) {
            // Controlla il campo
            if (!$field->isValid()) {
                return false; // Non valido
            }
        }
    }
    return true; // Valido
}

// ✅ CORRETTO
function validateFormFields(Form $form): bool {
    if ($form->hasNoFields()) {
        return true;
    }
    
    return $form->getFields()->every(fn(Field $field) => $field->isValid());
}
```

### Form Processing
```php
// ❌ ERRATO
function process($response) {
    // Processa la risposta
    $data = $response->getData();
    // Salva nel database
    $this->save($data);
    // Invia email se necessario
    if ($response->shouldNotify()) {
        $this->sendEmail($response);
    }
}

// ✅ CORRETTO
function processFormResponse(FormResponse $response): void {
    $this->saveResponseData($response);
    
    if ($response->requiresNotification()) {
        $this->sendResponseNotification($response);
    }
}

private function saveResponseData(FormResponse $response): void {
    $this->repository->save($response->getProcessedData());
}

private function sendResponseNotification(FormResponse $response): void {
    $this->notificationService->sendFormCompletionEmail($response);
}
```

## Aggiornamenti e Manutenzione

### Revisione Periodica
- Rimuovere commenti obsoleti ogni sprint
- Aggiornare PHPDoc quando cambiano le signature
- Refactoring per migliorare auto-documentazione
- Validazione clean code in ogni PR

### Metriche di Qualità
- Rapporto commenti/codice < 10%
- Complessità ciclomatica < 10 per metodo
- Copertura PHPStan livello 9+ al 100%
- Nessun warning da PHP CS Fixer

## Collegamenti

- [Provider Patterns](./providers/provider-patterns.md) - Pattern per service provider
- [Architecture Overview](./architecture.md) - Architettura del modulo
- [Testing Guidelines](./testing.md) - Linee guida per i test

## Aggiornamenti

- **2025-07-29**: Creazione regole clean code per FormBuilder
- **2025-07-29**: Aggiunta regole specifiche sui commenti
- **2025-07-29**: Definizione anti-pattern e best practices

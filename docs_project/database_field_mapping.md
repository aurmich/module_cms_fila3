# Mappatura dei Campi Database nel Modulo Patient

## Panoramica

Questo documento descrive la mappatura dei campi tra i modelli e le tabelle del database nel modulo Patient, con particolare attenzione alla gestione dei campi per i modelli `Doctor` e `Patient`.

## Struttura della Tabella `users`

La tabella `users` è condivisa tra diversi tipi di utenti (dottori, pazienti) attraverso il pattern Single Table Inheritance (STI). È importante comprendere quali campi sono disponibili in questa tabella per evitare errori durante la creazione o l'aggiornamento dei record.

### Campi Disponibili

| Campo | Tipo | Descrizione | Utilizzato da |
|-------|------|-------------|--------------|
| id | uuid | Identificatore univoco | Tutti |
| type | string | Tipo di utente (doctor, patient) | Tutti |
| first_name | string | Nome | Tutti |
| last_name | string | Cognome | Tutti |
| email | string | Indirizzo email | Tutti |
| phone | string | Numero di telefono | Tutti |
| address | string | Indirizzo | Tutti |
| city | string | Città | Tutti |
| certifications | json | Certificazioni (array) | Doctor |

### Campi NON Disponibili

| Campo | Modello | Alternativa |
|-------|---------|-------------|
| full_name | Doctor | Utilizzare `first_name` e `last_name` |
| certification | Doctor | Utilizzare `certifications` (array) |

## Gestione dei File

Per i campi che contengono file (come certificazioni), è importante seguire queste linee guida:

1. **Utilizzare il Campo Corretto**: Usare `certifications` (array) invece di `certification` (singolo)
2. **Configurazione del Form**: Configurare correttamente il componente `FileUpload` in Filament
3. **Salvataggio**: I file vengono salvati nella directory specificata nel componente `FileUpload`

```php
// Configurazione corretta in Filament
Forms\Components\FileUpload::make('certifications')
    ->multiple()
    ->directory('doctors/certifications')
    ->acceptedFileTypes(['application/pdf'])
```

## Errori Comuni

### 1. Utilizzo di Campi Non Esistenti

```php
// ❌ ERRATO: 'certification' non esiste nella tabella users
Doctor::create([
    'first_name' => 'John',
    'last_name' => 'Doe',
    'certification' => 'path/to/file.pdf', // Errore: colonna non trovata
]);

// ✅ CORRETTO: utilizzare 'certifications' (array)
Doctor::create([
    'first_name' => 'John',
    'last_name' => 'Doe',
    'certifications' => ['path/to/file.pdf'], // Corretto
]);
```

### 2. Utilizzo di `full_name` invece di `first_name` e `last_name`

```php
// ❌ ERRATO: 'full_name' non è più utilizzato
Doctor::create([
    'full_name' => 'John Doe', // Errore: colonna non trovata
    'email' => 'john@example.com',
]);

// ✅ CORRETTO: utilizzare 'first_name' e 'last_name'
Doctor::create([
    'first_name' => 'John',
    'last_name' => 'Doe',
    'email' => 'john@example.com',
]);
```

## Migrazione da `full_name` a `first_name`/`last_name`

Se stai aggiornando codice esistente che utilizza `full_name`, segui questi passaggi:

1. **Aggiorna i Form**: Sostituisci i campi `full_name` con `first_name` e `last_name`
2. **Aggiorna le Azioni**: Modifica le azioni per utilizzare i nuovi campi
3. **Aggiorna le Viste**: Aggiorna le viste per visualizzare i nuovi campi

## Gestione delle Certificazioni

Le certificazioni dei dottori sono gestite come array JSON nel campo `certifications`. Questo permette di salvare multiple certificazioni per ogni dottore.

```php
// Esempio di salvataggio di certificazioni
$doctor = Doctor::create([
    'first_name' => 'John',
    'last_name' => 'Doe',
    'email' => 'john@example.com',
    'certifications' => [
        'certifications/file1.pdf',
        'certifications/file2.pdf',
    ],
]);
```

## Documentazione Correlata

- [Pattern di Ereditarietà dei Modelli](/laravel/Modules/Patient/docs/MODEL_INHERITANCE_PATTERN.md)
- [Gestione dei File in Filament](/docs/filament-file-uploads.md)
- [Migrazione del Database](/docs/database-migrations.md)
- [Single Table Inheritance](/docs/model-inheritance-patterns.md)
- [Gestione degli Utenti](/docs/user-management.md)

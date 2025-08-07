# Convenzioni di Nomenclatura nel Modulo Patient

## Introduzione

Questo documento descrive le convenzioni di nomenclatura specifiche per il modulo Patient, in linea con le convenzioni generali del progetto il progetto.

## Campi per i Nomi Personali

> **IMPORTANTE**: In tutto il modulo Patient, utilizziamo **sempre** `first_name` e `last_name` per i campi relativi ai nomi delle persone, e **mai** `name` e `surname`. Per maggiori dettagli, consultare la [documentazione completa](../../Xot/docs/conventions/personal-name-fields.md).

### Esempi Corretti

```php
// Migrations
Schema::create('patients', function (Blueprint $table) {
    $table->id();
    $table->string('first_name');
    $table->string('last_name');
    // ...
});

// Filament Forms
Forms\Components\TextInput::make('first_name')
    ->label(trans('patient-resource.fields.first_name.label'))
    ->required();

Forms\Components\TextInput::make('last_name')
    ->label(trans('patient-resource.fields.last_name.label'))
    ->required();
```

### Esempi Errati

```php
// ❌ MAI utilizzare questi campi
Schema::create('patients', function (Blueprint $table) {
    $table->string('name');     // Errato
    $table->string('surname');  // Errato
});

// ❌ MAI utilizzare questi campi in Filament
Forms\Components\TextInput::make('name');     // Errato
Forms\Components\TextInput::make('surname');  // Errato
```

## Altre Convenzioni di Nomenclatura

### Tabelle

- Utilizzare il plurale per le tabelle (es. `patients`, `doctors`)
- Utilizzare snake_case (es. `medical_records`)

### Colonne

- Utilizzare snake_case (es. `birth_date`, `fiscal_code`)
- Utilizzare `_id` come suffisso per le chiavi esterne (es. `doctor_id`)
- Utilizzare `_at` come suffisso per i timestamp (es. `registered_at`)

### Filament Resources

- Utilizzare PascalCase e terminare con `Resource` (es. `PatientResource`, `DoctorResource`)
- Utilizzare nomi singolari per le risorse

## Collegamenti Bidirezionali

- [Convenzioni di Nomenclatura Generali](../../Xot/docs/naming-conventions.md)
- [Campi per i Nomi Personali](../../Xot/docs/conventions/personal-name-fields.md)
- [Linee Guida per i Database](../../Xot/docs/database-guidelines.md)

# Convenzioni di Naming nei Form

## Campi Persona

### Nome e Cognome
❌ **NON USARE**:
- `name` (troppo generico)
- `complete_name` (non standard)
- `fullname` (manca underscore)

✅ **USARE**:
- `full_name` (standard per nome e cognome completo)

### Motivazioni
1. **Chiarezza**
   - `full_name` è auto-esplicativo
   - Indica chiaramente che contiene sia nome che cognome
   - Evita ambiguità con altri tipi di nomi

2. **Consistenza**
   - Segue le convenzioni Laravel/Filament
   - Usa underscore per separare le parole
   - Mantiene coerenza nel codebase

3. **Internazionalizzazione**
   - Facilita le traduzioni
   - Chiaro per i traduttori
   - Consistente nelle diverse lingue

4. **Database**
   - Nome colonna standard
   - Compatibile con le convenzioni ORM
   - Facilita le migrazioni

## Altri Campi Comuni

### Contatti
- `email` (indirizzo email)
- `phone` (telefono fisso)
- `mobile` (cellulare)

### Indirizzi
- `address` (indirizzo completo)
- `street` (via)
- `city` (città)
- `postal_code` (CAP)
- `country` (nazione)

### Date
- `birth_date` (data di nascita)
- `registration_date` (data registrazione)
- `expiry_date` (data scadenza)

## Best Practices

1. **Naming**
   - Usa nomi descrittivi
   - Segui le convenzioni del framework
   - Mantieni consistenza nel progetto

2. **Struttura**
   - Usa underscore per separare parole
   - Evita abbreviazioni ambigue
   - Mantieni nomi concisi ma chiari

3. **Documentazione**
   - Documenta scelte non standard
   - Spiega acronimi o abbreviazioni
   - Mantieni aggiornata la documentazione

## Collegamenti
- [Form Implementation Errors](form-implementation-errors.md)
- [Form Components](filament-form-components.md)
- [Translation System](../../Lang/docs/translation-system.md)

## Vedi Anche
- [Laravel Naming Conventions](https://laravel.com/docs/master/eloquent#eloquent-model-conventions)
- [Filament Form Fields](https://filamentphp.com/docs/forms/fields)

## Collegamenti tra versioni di naming-conventions.md
* [naming-conventions.md](../../../../docs/naming-conventions.md)
* [naming-conventions.md](../../Xot/docs/naming-conventions.md)
* [naming-conventions.md](../../UI/docs/naming-conventions.md)

# Regola Directory Obbligatoria

Tutte le classi PHP (Models, Enums, Actions, Providers, View/Components, ecc.) DEVONO essere in `app/`.

- ❌ Sbagliato: `Modules/SaluteOra/Enums/UserType.php`
- ✅ Corretto: `Modules/SaluteOra/app/Enums/UserType.php`

Consulta sempre:
- [MIGLIORAMENTI_E_CORREZIONI.md](./MIGLIORAMENTI_E_CORREZIONI.md)
- [CURSOR_RULES.md](./CURSOR_RULES.md)
- [WINDSURF_RULES.md](./WINDSURF_RULES.md)

## FAQ/Warning: Namespace errato nei Provider

### Errore tipico

```
Class "Modules\SaluteOra\app\Providers\SaluteOraServiceProvider" not found
```

**Motivo:**
- Namespace dichiarato come `Modules\SaluteOra\app\Providers` invece di `Modules\SaluteOra\Providers`.
- L'autoload PSR-4 mappa `app/` su `Modules\SaluteOra\`.

**Soluzione:**
- Il file deve essere in `app/Providers/SaluteOraServiceProvider.php`
- Il namespace deve essere:
  ```php
  namespace Modules\SaluteOra\Providers;
  ```
- Tutti i riferimenti (config/app.php, moduli, test) devono puntare a `Modules\SaluteOra\Providers\SaluteOraServiceProvider::class`
- Esegui sempre `composer dump-autoload` dopo ogni modifica ai namespace.

**Consulta anche:**
- [MIGLIORAMENTI_E_CORREZIONI.md](./MIGLIORAMENTI_E_CORREZIONI.md)
- [namespace-vs-file-structure.md](./namespace-vs-file-structure.md)

